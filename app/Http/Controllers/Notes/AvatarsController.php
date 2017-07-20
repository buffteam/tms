<?php

namespace App\Http\Controllers\Notes;

use App\Avatars;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\upload;
use Illuminate\Support\Facades\Auth;

class AvatarsController extends Controller
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
        $upload = new upload('avatar','uploads');
        $param = $upload->uploadFile();
        if ( !$param['status'] ) {
            return back()->withErrors([['avatar'=>$param['data']]]);
        }
        $userId = Auth::user()->id;
        $status = $this->insertAvatar($param['data'],$userId);
        return view('auth.avatar',['list'=>$this->findAvatars($userId),'status'=>$status]);

    }
    public function insertAvatar ($url,$userId)
    {
        return Avatars::create(['url'=>$url,'u_id'=>$userId]) ? '上传成功' : '上传失败';
    }
    public function findAvatars ($userId)
    {
        return Avatars::where('u_id',$userId)->get();
    }

}
