<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Libs\upload;
class UtilController extends BaseController
{
    /*
     * 文件上传
     */
    public function upload () {
        if (!isset($_FILES['editormd-image-file'])) {
            return $this->setMsg('参数错误')->responseError();
        }
        $upload = new upload('editormd-image-file','uploads');
        $param = $upload->uploadFile();
        if ( $param['status'] ) {
            return response()->json(array('success'=>1,'message'=>'上传成功','url'=>$param['data']));
        }
        return response()->json(array('success'=>1,'message'=>'上传失败','url'=>$param['data']));


    }
}
