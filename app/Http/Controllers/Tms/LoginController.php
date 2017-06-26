<?php

namespace App\Http\Controllers\Tms;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Cookie;
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



        // 查看是否存在log_token cookie
       /* if (isset($_COOKIE['log_token'])) {
            $log_token = $_COOKIE['log_token'];
            $tokenData =  DB::table('users_token')->where('token',$log_token)->select('uid','token_expired')->first();
            // 如果过期了跳转到登录
            if ( $tokenData->token_expired > time() ) {
                $user = DB::table('users')->where('id',$tokenData->uid)->select('id','auth','email','avatar')->get()->toArray();
                if ($user !== null) {
                    session('user',$user);
                    return redirect('dashboard');
                }

            }
        }*/



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

            $userInfo = $this->insertUsersToken($userData->id,$request->ip(),$param['username']);

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
    protected function insertUsersToken ($userId,$userIp,$username) {

        $user = DB::table('users_token');
        $data = ['uid'=>$userId,'token'=> str_random(32),'ip'=>$userIp,'token_expired'=> time() + 60*60*24,'add_time'=>time()];
        $insertToken = $user->insert($data);
        if ($insertToken) {
            // 登录信息存储在session当中
            $data['username'] = $username;
            session(['user'=>$data]);
            setcookie('log_token', $data['token'], time()+24*3600);
            return $data;
        }
        return false;
    }
}
