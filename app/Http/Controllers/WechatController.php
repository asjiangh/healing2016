<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use GuzzleHttp;
use Illuminate\Contracts\Redis;
use App\Service\UserInfo;
use App\Http\Requests;


class WechatController extends Controller
{
    public function getConfig(Application $app, Requests\WechatConfigRequest $request)
    {
        return $app->js->config($request->input('type'));
    }

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
