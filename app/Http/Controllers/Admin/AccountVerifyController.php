<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountVerifyController extends BaseController
{
    //
    public function index()
    {
        $list = User::where('auth',0)->get();
        return view('admin.account',['list'=>$list]);
    }
    public function verify(Request $request)
    {
        if(!$request->has('id')) {
            return $this->ajaxError('参数不正确');
        }
        $id = $request->input('id');
        $condition = User::where('id',$id);
        $user = $condition->get()->toArray();
        $flag = preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $user[0]['name']);
        if (!$flag) {
            return $this->ajaxError('用户昵称必须是中文名字');
        }
        if (!preg_match('/^\w+(@oaserver.dw.gdbbk.com)$/',$user[0]['email'])){
           return $this->ajaxError('必须使用邮箱使用OA邮箱');
        }

        if ($condition->update(['auth'=>9])) {
           return $this->ajaxSuccess('审核通过');
        }




    }
}
