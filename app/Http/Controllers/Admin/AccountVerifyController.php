<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountVerifyController extends Controller
{
    //
    public function index()
    {
        $list = User::where('auth',0)->get();
        return view('admin.account',['list'=>$list]);
    }
}
