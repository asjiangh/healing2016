<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTFactory;

class JwtController extends Controller
{
    public function sentToken()
    {
        $customClaims = session('wechat.oauth_user');

        $payload = JWTFactory::make($customClaims);

        try {
            $token = JWTAuth::encode($payload);
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return view('token', compact('token', 'customClaims'));
    }
}
