<?php

namespace App\Http\Controllers;
use App\Folder;
use App\User;
use Illuminate\Support\Facades\App;
use App\Notes;
use App\Libs\upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonController extends BaseController
{
    protected $rootDir = 'http://172.28.2.228/stip/public/';
    /**
     * md笔记上传图片
     * @return \Illuminate\Http\JsonResponse
     */
    public function mdEditorUpload () {
        if (!isset($_FILES['editormd-image-file'])) {
            return $this->error('参数错误');
        }
        $upload = new upload('editormd-image-file','/uploads');
        $param = $upload->uploadFile();
        if ( $param['status'] ) {
            return response()->json(array('success'=>1,'message'=>'上传成功','url'=>$param['data'],'data'=>[$param['data']]));
        }
        return response()->json(array('success'=>0,'message'=>'上传失败','url'=>$param['data'],'data'=>$param['data']));


    }

    /**
     * 普通笔记上传图片
     * @return \Illuminate\Http\JsonResponse
     */
    public function wangEditorUpload () {
        if (!isset($_FILES['image-file'])) {
            return $this->error('参数错误');
        }
        $upload = new upload('image-file','/uploads');
        $param = $upload->uploadFile();
        if ( $param['status'] ) {
            return response()->json(array('errno'=>0,'message'=>'上传成功','data'=>[$param['data']]));
        }
        return response()->json(array('errno'=>1,'message'=>'上传失败','data'=>$param['data']));


    }

    /**
     * 验证登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkLogin()
    {
        return Auth::check() ? $this->success('登录成功',user()) : $this->error('登录过期');
    }

    /**
     *  中转页面提示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function prompt ()
    {
        if(!empty(session('message')) && !empty(session('url')) && !empty(session('jumpTime'))){
            $data = [
                'message' => session('message'),
                'url' => session('url'),
                'jumpTime' => session('jumpTime'),
                'status' => session('status')
            ];
        } else {
            $data = [
                'message' => '请勿非法访问！',
                'url' => '/',
                'jumpTime' => 3,
                'status' => false
            ];
        }
        return view('common.prompt',['data' => $data]);
    }

}
