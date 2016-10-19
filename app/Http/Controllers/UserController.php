<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\User;

class UserController extends Controller
{
    protected $fields = [
        'nickname' => '',          //默认昵称
        'phone' => '',
        'school_id' => '',
        'headimgurl' => '',         //默认头像地址
    ];

    public function create(RegisterRequest $request)
    {
        $user = new User();
        foreach (array_keys($this->fileds) as $field)
        {
            $user->$field = $request->get($field);
        }
        $user->save();

        return redirect('welcome')->withSuccess("Welcome,'$user->nickname' .");

    }
}
