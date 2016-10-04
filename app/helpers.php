<?php

function getUserFromRedis($openid)
{
    if ($user = \Illuminate\Support\Facades\Redis::hmget($openid)){
        return false;
    }
    return $user;
}