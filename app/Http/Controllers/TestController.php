<?php

namespace App\Http\Controllers;

use App\ForgetToken;
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
    public function test ()
    {

        $flag = ForgetToken::create(['email'=>user()->email,'forget_token'=>str_random(32),'expired_time'=>time() + 30*60]);
        dump($flag);
//        $result =   Mail::to(user()->email)->send(new ResetPassword($flag));
//        dump($result);
//        return $result ? response()->json(array('code'=>200,'result'=>'发送成功'))
//            : response()->json(array('code'=>403,'result'=>'发送失败'));

//        $data = Notes::find(19);
//        return view('test',['list'=>$data]);
    }
}
