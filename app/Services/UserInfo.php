<?php

namespace App\Service;

use Illuminate\Support\Facades\Redis;

class UserInfo
{
    public function getCode()
    {
        $appid = config('app_id');
        $redirect_url = '';        //回调页面
        $redirect_url = urlencode($redirect_url);
        $code = $_GET['code'];
        $url_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
";   //授权，自行更改
        if(!isset($code)){
            header("Location: $url_code");
            $this->getAccessToken();
        }
        $this->getAccessToken();

        /*
        return compact(
            'code',
            'openid',
            'access_token',
            'token',
            'user_info'
        );
        */
    }

    public function getAccessToken()
    {
        $appid = config('app_id');      //appid
        $secret = config('secret');     //appsecret
        $code = $_GET['code'];
        $url_token = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code";   //token获取，自行更改
        $content_token = file_get_contents($url_token);
        $token = json_decode($content_token,true);
        $_SESSION['TOKEN'] = $token;
        $openid = $token['openid'];
        $access_token = $token['access_token'];
        // echo($token);
        // echo($openid);
        // echo($access_token);
        if($code && $token){
            $this->getUserInfo();
        }
    }

    public function getUserInfo()
    {
        $url_info = "https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN";   //信息,自行更改
        $content_info = file_get_contents($url_info);
        $info = json_decode($content_info,true);
        // echo($info);           //json格式信息
        Redis::set("info",$info);
        $user_info = Redis::get("info");
        //echo($user_info);          //存入redis的用户基本信息

    }

}