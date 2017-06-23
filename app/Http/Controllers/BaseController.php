<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
    private $responseData = ['code'=>200,'msg'=>'默认描述信息'];

    /**
     * 返回正确信息
     * @return array
     */
    protected function response () {

        $param = func_get_args();

        if (count($param) > 0) {
            $this->responseData['data'] = $param[0];
        }
        if (count($param) > 1) {
            $this->responseData['msg'] = $param[1];
        }
        return $this->responseData;

    }

    protected function responseError ($error = null,$msg = '请求出错') {

        $this->responseData['code'] = 403;
        $this->responseData['msg'] = $msg;
        $this->responseData['error'] = $error;

        return $this->responseData;

    }
    protected function setCode ($code = 200) {

        $this->responseData['code'] = $code;

        return $this;

    }
    protected function setMsg ($msg = '请求成功') {

        $this->responseData['msg'] = $msg;

        return $this;

    }
    protected function setError ($error = null) {

        $this->responseData['error'] = $error;

        return $this;

    }
}
