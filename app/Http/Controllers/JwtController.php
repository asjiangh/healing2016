<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class JwtController extends Controller
{
    public function sentToken()
    {
        $openid = session('wechat.oauth_user')['id'];

        $payload = JWTFactory::sub($openid)->make();

        try {
            $token = JWTAuth::encode($payload);
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return view('token', compact('token'));
    }

    public function testSentToken()
    {
        $openid = 'asdfasdfqwerqer';

        $payload = JWTFactory::sub($openid)->make();

        try {
            $token = JWTAuth::encode($payload);
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return view('token', compact('token'));
    }

    public function checkToken()
    {
        $user = getUserFromRedis(session('wechat.oauth_user')[id]);
        return view('check', compact('user'));
    }

    public function userInfo()
    {
        echoTest();
        dd(session('wechat.oauth_user'));
    }
}
