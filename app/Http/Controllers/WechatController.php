<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use Illuminate\Contracts\Redis;
use App\Service\UserInfo;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;


class WechatController extends Controller
{
    public function _construct(UserInfo $transmit)
    {
        $this->transmit = $transmit;
    }

    public function index()
    {
        $info = $this->transmit->getCode();

        return response()->json($info);           //传info
    }

    public function tokenInfo()
    {
        $token = $_SESSION['TOKEN'];
        return view('token',compact($token));         //传token
    }
}