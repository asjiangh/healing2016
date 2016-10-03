<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function userInfo()
    {
        $user = session('wechat.oauth_user');
//        $user = 'test';
        var_dump($user);
        echo '<br>/*****************************************/';
        dd($user);
    }
}
