<?php

namespace SongList;

use Illuminate\Support\Facades\Redis;

class SongList
{
    public function getRandomSongList($num)
    {
        if (! $randomSongList = Redis::lrange()){
            //
        }
        $this->updateOffset();
        return $randomSongList;
    }

    protected function updateOffset()
    {
        //
    }
}