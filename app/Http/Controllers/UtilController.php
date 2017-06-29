<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\upload;
class UtilController extends Controller
{
    /*
     * 文件上传
     */
    public function upload () {
        $upload = new upload('file','upload');
        $dest = $upload->uploadFile();
        if ( $dest ) {
            return response()->json([ 'code' => 200,'msg' => $dest,'result' => null]);
        }
        return response()->json([ 'code' => 102,'msg' => '','result' => $dest]);
    }
}
