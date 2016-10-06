<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtAuthenticate extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->authenticate($request);
        return $next($request);
    }

    public function authenticate(Request $request)
    {
        $this->checkForToken($request);

        $openid = $this->auth->parseToken()->getPayload()->get('sub');

        if (!$user = Redis::hgetall($openid)) {
            return false;
        }

        return $user;
    }
}
