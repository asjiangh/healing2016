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

    protected $list_total, $table_offset, $table_total, $list_page, $end;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->list_total = config('song.songs_per_list');
        $this->table_offset = $this->getTableOffset();
        $this->table_total = $this->getTableTotal();
        $this->end = $this->table_offset + $this->list_total;
        $this->list_page = config('song.song_per_page');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->generateList();
    }

    protected function generateList()
    {
        $list = $this->getList();

        if ($this->table_offset < $this->table_total) {

            $overflow = $this->table_offset + $this->list_total - $this->table_total;

            if ($overflow > 0) {

                $this->table_offset = $overflow;

                $this->table_total = $this->list_total - $overflow;

                $list = array_merge($list, $this->getList());

            }

            $this->updateOffset();

        }

        shuffle($list);

        $list = $this->chunkList($list);

        return $this->cacheList($list);
    }

    protected function getTableOffset()
    {
        $offset = Redis::get('song_table_offset');
        if ($offset == false) {
            Redis::set('song_table_offset', 0);
            $offset = 0;
        }
        return $offset;
    }

    protected function updateOffset()
    {
        return Redis::set('song_list_offset', $this->table_offset + $this->list_total);
    }

    protected function cacheList($list)
    {
        Redis::rpush('song_list', $list);
    }

    protected function getList()
    {
        $list = Song::select('meta')->whereNull('healed_at')
            ->limit($this->table_offset, $this->list_total)
            ->get()
            ->toArray();

        $list = array_chunk($list, $this->list_page);

        $list = array_map('json_encode', $list);

        return $list;
    }

    protected function getTableTotal()
    {
        $total = Song::count();
        return $total;
    }

    protected function chunkList($list)
    {
        return array_map('json_encode', array_chunk($list, $this->list_page));
    }
}
