<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    public function store(Request $request)
    {
        // validate 方法接收两个参数
        // 表单验证机制 https://d.laravel-china.org/docs/5.5/validation
        // 第一个参数为用户输入数据
        // 第二个参数为数据数据的验证规则
        // required 用来验证字段是否为空，mix|max 用来验证最大和最小值
        // unique 主要为唯一性验证，unique:users 为验证用户表的唯一性
        // confirmed 用来进行密码匹配验证s
        $this->validate($request ,[
            'name'=>'required|max:50',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        // flash 为 session 方法存入一条缓存数据，让他只在下一次请求内有效
        // session()->flash('success','欢迎，你将在这里开始一段新的旅程');
        // return redirect()->route('users.show',[$user]);
        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开始一段新的旅程');
        return redirect()->route('users.show',[$user]);
    }
}
