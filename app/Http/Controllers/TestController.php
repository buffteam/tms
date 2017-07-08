<?php

namespace App\Http\Controllers;

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
}
