<?php

namespace App\Http\Controllers;

use App\ForgetToken;
use App\Mail\ResetPassword;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Mail;
use App\Model\Notes;
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
        dd($request->all());
        return response()->json();

    }
}
