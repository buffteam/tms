<?php

namespace App\Http\Controllers\Notes;

use Illuminate\Support\Facades\Validator;
use App\Avatars;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Libs\upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarsController extends BaseController
{

    public function index ()
    {

        $userId = Auth::user()->id;
        return view('auth.avatar',['list'=>$this->findAvatars($userId)]);
    }

    public function upload()
    {
        if (!isset($_FILES['avatar'])) {
            return back()->withErrors([['avatar'=>'参数不正确']]);
        }
        $user = Auth::user();
        $upload = new upload('avatar','uploads/avatar/'.$user->id.'/');
        $param = $upload->uploadFile();
        if ( !$param['status'] ) {
            return back()->withErrors([['avatar'=>$param['data']]]);
        }
        // 把图片地址插入头像表，然后并设置头像为当前上传的图片
        // 先把之前的头像设置失活
        Avatars::where('active',1)->update(['active'=>0]);
        // 然后插入新的头像，并设置为当前头像
        $status = $this->insertAvatar($param['data'],$user->id);
        //接着插入用户表
        $user->avatar = $param['data'];
        $user->save();
        return view('auth.avatar',['list'=>$this->findAvatars($user->id),'status'=>$status]);

    }
    public function insertAvatar ($url,$userId)
    {
        return Avatars::create(['url'=>$url,'u_id'=>$userId,'active'=>9]) ? '上传成功' : '上传失败';
    }
    public function findAvatars ($userId)
    {
        $common = Avatars::where('u_id',0);
        return Avatars::where('u_id',$userId)->union($common)->get();
    }

    public function selectAvatar (Request $request)
    {
        if (!$request->has('url')) {
            return $this->ajaxError('参数不正确');
        }
        $params = $request->only('url');
        $user = $request->user();
        $user->avatar = $params['url'];
        Avatars::where('url','!=',$params['url'])->where('active',1)->update(['active'=>0]);
        Avatars::where('url',$params['url'])->update(['active'=>1]);
        $flag = $user->save();
        return $this->ajaxSuccess('设置成功',$flag);
    }

    public function deleteAvatar (Request $request)
    {
        $rules =  [
            'idList' => 'required',
            'urlList' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ajaxError('参数验证输错',$validator->errors());
        }
        $params = $request->input();

        // 第一步删除数据地址，第二部删除存储器中文件
        $flag = Avatars::where('active',0)->whereIn('id',$params['idList'])->delete();
        if (!$flag) {
            return $this->ajaxError('删除失败');
        }
        $delFile = false;
        foreach ($params['urlList'] as $url) {
            $delFile = unlink($url);
        }
        if (!$delFile) {
            return $this->ajaxError('删除失败');
        }
        return $this->ajaxSuccess('删除成功');
    }


}
