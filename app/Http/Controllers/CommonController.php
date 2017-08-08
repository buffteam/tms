<?php

namespace App\Http\Controllers;
use App\Model\Folder;
use App\Model\Notes;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use App\Libs\upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonController extends BaseController
{

    /**
     * md上传图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mdEditorUpload (Request $request) {


        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('editormd-image-file')){
            return response()->json(array('success'=>0,'message'=>'上传失败,上传文件为空','url'=>null,'data'=>null));
        }
        $file = $request->file('editormd-image-file');
//        dd($file->getClientOriginalExtension());
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            return response()->json(array('success'=>0,'message'=>'上传失败,文件上传出错','url'=>null,'data'=>null));
        }
        $uploadPath = 'uploads/';
        if(!file_exists($uploadPath)) {
            mkdir($uploadPath,0777,true);
        }
        $renameFilename = md5(uniqid(microtime(true), true)).'.'.$file->getClientOriginalExtension();
        $flag = $file->move($uploadPath,$renameFilename);
        if(!$flag){
            return response()->json(array('success'=>0,'message'=>'上传失败','url'=>null,'data'=>null));
        }
        return response()->json(array('success'=>1,'message'=>'上传成功','url'=>asset($uploadPath.$renameFilename),'data'=>[asset($uploadPath.$renameFilename)]));

    }
    /**
     * 普通笔记上传图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wangEditorUpload (Request $request) {

        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('image-file')){
            return response()->json(array('errno'=>1,'message'=>'上传失败,上传文件为空','data'=>null));
        }
        $file = $request->file('image-file');
//        dd($file->getClientOriginalExtension());
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            return response()->json(array('errno'=>1,'message'=>'上传失败,文件上传出错','data'=>null));
        }
        $uploadPath = 'uploads/';
        if(!file_exists($uploadPath)) {
            mkdir($uploadPath,0777,true);
        }
        $renameFilename = md5(uniqid(microtime(true), true)).'.'.$file->getClientOriginalExtension();
        $flag = $file->move($uploadPath,$renameFilename);
        if(!$flag){
            return response()->json(array('errno'=>1,'message'=>'上传失败','data'=>null));
        }
        return response()->json(array('errno'=>0,'message'=>'上传成功','data'=>[asset($uploadPath.$renameFilename)]));

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

    public function exportmd(Request $request)
    {
        $id = $request->input('id');

        $notes = Notes::find($id);

        $md = $notes->origin_content;
        if (empty($md)){
            return  back()->withInput(['error'=>'内容不能为空']);
        }
        file_put_contents('exout.md',$md);

        return response()->download('exout.md');

    }
}
