<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class WechatController extends Controller
{
    public function getConfig(Application $app, Requests\WechatConfigRequest $request)
    {
        return $app->js->config($request->input('type'));
    }
}
