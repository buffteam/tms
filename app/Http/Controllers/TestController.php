<?php

namespace App\Http\Controllers;

use App\ForgetToken;
use App\Mail\ResetPassword;
use App\Notifications\UpdateInform;
use Illuminate\Notifications\Notifiable;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Mail;
use App\Model\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    use Notifiable;
    //
    public function log ()
    {
        DB::connection()->enableQueryLog();
        $log = DB::getQueryLog();
        dd($log);
    }
    public function test (Request $request)
    {
        Notification::send('',new UpdateInform());
        return view('test');

    }
}
