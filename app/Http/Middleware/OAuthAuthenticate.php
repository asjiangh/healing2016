<?php

namespace App\Http\Middleware;

use Closure;
use Event;
use Illuminate\Support\Facades\Redis;
use Overtrue\LaravelWechat\Events\WeChatUserAuthorized;

/**
 * Class OAuthAuthenticate.
 */
class OAuthAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $wechat = app('EasyWeChat\\Foundation\\Application', [config('wechat')]);

        $isNewSession = false;

        if (!session('wechat.oauth_user')) {
            if ($request->has('state') && $request->has('code')) {

//                session(['wechat.oauth_user' => $wechat->oauth->user()]);

                $user = $wechat->oauth->user();

                session(['wechat.oauth_user' => $user]);

                $user_in_redis = [
                    'openid' => $user->id,
                    'nickname' => $user->nickname,
                    'sex' => $user->original['sex'],
                    'avatar' => $user->avatar,
                    'privilege' => 0,
                ];
                Redis::hmset($user->id, $user_in_redis);

                $isNewSession = true;

                return redirect()->to($this->getTargetUrl($request));
            }

            $scopes = config('wechat.oauth.scopes', ['snsapi_base']);

            if (is_string($scopes)) {
                $scopes = array_map('trim', explode(',', $scopes));
            }

            return $wechat->oauth->scopes($scopes)->redirect($request->fullUrl());
        }

        Event::fire(new WeChatUserAuthorized(session('wechat.oauth_user'), $isNewSession));

        return $next($request);
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    public function getTargetUrl($request)
    {
        $queries = array_except($request->query(), ['code', 'state']);

        return $request->url() . (empty($queries) ? '' : '?' . http_build_query($queries));
    }
}
