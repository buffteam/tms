<?php

namespace App\Http\Controllers\Tms;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    //
    public function index() {
        return view('public/login');
    }

    public function check ($request) {
        // 验证规则
        $rules =  [
            'username' => 'required|max:40',
            'password' => 'required|max:40',
        ];

        $validator = Validator::make($request->all(), $rules);

        return  $validator->fails() ? $validator->errors() : true;

    }

    public function login (Request $request) {
        // 验证用户提交数据
        $check = $this->check($request);

        if ($check !== true) {
            return response($this->responseError($check));
        }

        $user = DB::table('users');
        $param = $request->input();
        $userData = $user->where(['username'=>$param['username']])->select('id','password')->first();

        if ($userData === null) {
            return $this->responseError('用户名不存在','登陆出错');
        }

        $check_pass = Hash::check($param['password'], $userData->password);

        if ($check_pass) {
            $userInfo = $this->insertUsersToken($userData->id,$request->ip());
//            $this->setMsg('登录成功')->response($userInfo)
            return (false !== $userInfo)  ? redirect()->route('dashboard') : $this->responseError(null,'服务器出了点小差错');

        }
        return $this->responseError('密码不正确','登陆出错');

    }

    /**
     * 插入token
     * @param $userId
     * @param $userIp
     * @return array|bool
     */
    protected function insertUsersToken ($userId,$userIp) {

        $user = DB::table('users_token');
        $data = ['uid'=>$userId,'token'=> str_random(32),'ip'=>$userIp,'token_expired'=> time() + 60*60*24,'add_time'=>time()];
        $insertToken = $user->insert($data);
        if ($insertToken) {
            return $data;
        }
        return false;
    }
}
