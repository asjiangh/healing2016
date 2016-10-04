<?php

namespace App\Http\Controllers\API;

use App\Song;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class SongController extends Controller
{
    /**
     * Return all songs. Will be change later.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $songs = Song::select('name', 'user_id', 'dial_times', 'healed_at', 'created_at')->get();

        if (!$songs) {
            return response()->json(['error' => 'No songs.'], 404);
        }

        return response()->json($songs);
    }

    public function show($name)
    {
        $songs = Song::select('name', 'user_id', 'dial_times', 'healed_at', 'created_at')
            ->where('name', $name)
            ->get();

        if (!$songs) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        return response()->json($songs->paginate(config('song.songs_per_page')));
    }

    public function store(Requests\SongCreateRequest $request)
    {
        $song_name = $request->get('name');

        $user = JWTAuth::parseToken()->authenticate();
        dd($user);

        $result = Song::create(['']);
    }
}
