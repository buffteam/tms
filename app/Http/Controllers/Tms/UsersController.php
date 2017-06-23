<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\BaseController;
use App\Model\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UsersController extends BaseController
{

    //
    protected function check  ($request){
        // 验证规则
        $rules =  [
            'username' => 'required|max:40',
            'password' => 'required|max:40',
            'email' => 'required|email|max:80',
        ];

        $validator = Validator::make($request->all(), $rules);

        return  $validator->fails() ? $validator->errors() : true;
    }


    /**
     * 检查邮箱是否存在
     * @param $email
     * @return bool
     */
    protected function checkFieldExist ($field,$email) {

        $user = new User();

        $fieldExist = $user::where($field,$email)->first();

        if ($fieldExist !== null) {
            return true;
        }
        return false;
    }

    /**
     * 插入数据
     * @param $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function create ($request) {
        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->email= $request->email;
        $user->auth = 1;
        $user->avatar = '/uploads/avatar/github.jpg';
        if ($user->save()) {
            return response($this->setMsg('注册成功')->response( ['id' => $user->id, 'username' => $user->username,]));
        }
        return response($this->responseError($user->saveOrFail()));
    }
}
