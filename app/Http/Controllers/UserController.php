<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function getModify()
    {
        return view('auth.modify');
    }
    public function postModify(Request $request)
    {
        $oldpassword = $request->input('oldpassword');
        $password = $request->input('password');
        $data = $request->all();
        $rules = [
            'oldpassword'=>'required|between:6,20',
            'password'=>'required|between:6,20|confirmed',
        ];
        $messages = [
            'required' => '密码不能为空',
            'between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $validator = Validator::make($data, $rules, $messages);
        $user = Auth::user();
        $validator->after(function($validator) use ($oldpassword, $user) {
            if (!Hash::check($oldpassword, $user->password)) {
                $validator->errors()->add('oldpassword', '原密码错误');
            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator);  //返回一次性错误
        }
        $user->password = bcrypt($password);
        $user->save();
        Auth::logout();  //更改完这次密码后，退出这个用户
        return redirect('/login');
    }

    public function checkEmail ()
    {
        return view('auth.email');
    }
    public function handleEmail (Request $request)
    {
        // 验证传输过来的邮箱
        $this->validate($request,['email'=>'required|email']);

        //验证邮箱是否存在
        $flag = User::where('email',$request->input('email'))->count();
        if ($flag < 1) {
            return back()->withErrors(['error'=>'邮箱未注册！']);
        }
        //生成token
    }

    public function getForget ()
    {
        return view('auth.forget');
    }
}
