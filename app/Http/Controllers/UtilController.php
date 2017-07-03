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
        if (!isset($_FILES['file'])) {
            return $this->setMsg('参数错误')->responseError();
        }
        $upload = new upload('file','uploads');
        $param = $upload->uploadFile();
        if ( $param['status'] ) {
            return $this->setMsg('上传成功')->response(array('url'=>$param['data']));
        }
        return $this->responseError($param['data'],'上传失败');
    }
}
