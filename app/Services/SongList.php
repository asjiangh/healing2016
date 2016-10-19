<?php

namespace App\Services;

use App\Song;
use App\Tag;
use Illuminate\Support\Facades\Redis;

class SongList
{
    public function getRandomSongList($num)
    {
        $num = config('song.songs_per_page');

        $randomSongList = Redis::lrange('song_list', 0, $num);

        return $randomSongList;
    }

    public function getSongsByTag($tag)
    {
        $tag = Tag::where('tag', $tag)->firstOrFail();

        $songs = Song::where('published_at', '<=', Carbon::now())
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag', '=', $tag->tag);
            })
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->simplePaginate(config('song.songs_per_page'));

        $songs->addQuery('tag', $tag->tag);

        $page_image = $tag->page_image ?: config('song.page_image');

        return [
            'title' => $tag->title,
            'subtitle' => $tag->subtitle,
            'songs' => $songs,
            'page_image' => $page_image,
            'tag' => $tag,
        ];
    }
}