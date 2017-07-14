<?php

namespace App\Http\Controllers;

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
//        $data = Notes::find(19);
//        return view('test',['list'=>$data]);
    }
}
