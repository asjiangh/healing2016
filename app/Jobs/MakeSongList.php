<?php

namespace App\Jobs;

use App\Song;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class MakeSongList implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $total, $offset, $half;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->total = config('song.songs_per_list');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->generateList();
    }

    protected function generateList()
    {
        $this->getOffset();

        $list = Song::with('user')->select('song.id', 'song.name', 'user.name as user_name', 'dail_times')
            ->whereNull('healed_at')
            ->limit($this->offset, $this->total)
            ->get()
            ->toArray();

        dd($list);
        $this->updateOffset();

        shuffle($list);

        return $this->cacheList($list);
    }

    protected function getOffset()
    {
        if (!$this->offset = Redis::get('song_list_offset')) {
            Redis::set('song_list_offset', 0);
            return $this->offset = 0;
        }
        return $this->offset;
    }

    protected function updateOffset()
    {
        return Redis::set('song_list_offset', $this->offset + $this->total);
    }

    protected function cacheList($list)
    {
        Redis::pipeline(function ($pipe) use ($list) {
            for ($i = 0; $i < 100; $i++) {
                $pipe->hmset("song_list:$i", $list[$i]);
            }
        });

        return 1;
    }
}
