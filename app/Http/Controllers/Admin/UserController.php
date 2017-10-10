<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::whereIn('auth',[2,9])->paginate(15);
        return view('admin.users.index',['list'=>$users]);
    }
}
