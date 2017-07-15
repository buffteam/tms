<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use App\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //
    public function log ()
    {
        DB::connection()->enableQueryLog();
        $log = DB::getQueryLog();
        dd($log);
    }
    public function test (Request $request)
    {
        $result =   Mail::to($request->input('email'))->send(new ResetPassword());
        dump($result);
        return $result ? response()->json(array('code'=>200,'result'=>'发送成功'))
            : response()->json(array('code'=>403,'result'=>'发送失败'));

//        $data = Notes::find(19);
//        return view('test',['list'=>$data]);
    }
}
