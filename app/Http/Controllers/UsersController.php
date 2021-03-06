<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        // middleware 接收两个参数，第一个为中间件名称，第二个为要过滤的动作
        // except 方法设定指定动作不被 Auth 中间件过滤
        $this->middleware('auth',[
            'except' => ['show','create','store','index']
        ]);
        // 只让未登录用户访问注册页面
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }
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

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }

    public function index()
    {
        // $users = User::all();
        // return view('users.index', compact('users'));
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    public function destroy(User $user)
    {
        // 通过 authorize 方法对删除操作进行授权验证
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除用户!');
        return back();
    }



}
