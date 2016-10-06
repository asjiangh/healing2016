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
    public function sentToken($url = 'aHR0cDovL3JlcG8uZ2F5aHViLmNu')
    {
        $openid = session('wechat.oauth_user')['id'];

        $url = base64_decode($url);

        $payload = JWTFactory::sub($openid)->iss($url)->make();

        try {
            $token = JWTAuth::encode($payload);
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return view('token', compact('token', 'url'));
    }

    public function testSentToken()
    {
        $openid = 'asdfasdfqwerqer';

        $url = 'http://test.dev';

        $customClaims = ['sub' => $openid, 'http' => $url];

        $payload = JWTFactory::sub('abc')->make();
        Redis::hmset('abc', $customClaims);

        try {
            $token = JWTAuth::encode($payload);
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return view('token', compact('token', 'url'));
    }

    public function checkToken()
    {
        $user = getUserFromRedis(session('wechat.oauth_user')[id]);
        echoTest();
        return view('check', compact('user'));
    }

    public function userInfo()
    {
        echoTest();
        dd(session('wechat.oauth_user'));
    }
}
