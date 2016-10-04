<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class JwtController extends Controller
{
    public function sentToken()
    {
        // $openid = session('wechat.oauth_user')['id'];
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
        return view('check');
    }
}
