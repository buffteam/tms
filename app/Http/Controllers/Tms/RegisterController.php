<?php

namespace App\Http\Controllers\Tms;

use Illuminate\Http\Request;
use App\Http\Controllers\Tms\UsersController;

class RegisterController extends UsersController
{
    // 注册
    public function register () {

        return view('public/register');

    }

    // 注册
    public function doRegister (Request $request) {
        // 验证用户提交数据
        $check = $this->check($request);

        if ($check !== true) {
            return response($this->responseError($check));
        }
        //TODO 如果刚刚注册存入session中去，以便登录时用和避免重复提交时再次查询数据库减少数据库的压力

        $param = $request->input();

        if ($this->checkFieldExist('username',$param['username'])) {
            return response($this->responseError("用户名已存在"));
        }

        if ($this->checkFieldExist('email',$param['email'])) {
            return response($this->responseError("邮箱已注册"));
        }
        // 插入数据
        return $this->create($request);

    }
}
