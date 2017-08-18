<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $params = $this->addSuffix($data);
        return Validator::make($params, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ],[
            'password.confirmed' => '两次密码输入不一致',
            'email.unique' => '该邮箱已经被注册了',
            'name.unique' => '该昵称被占用了'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $params = $this->addSuffix($data);
        return User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => bcrypt($params['password']),
        ]);
    }

    protected function addSuffix(array $data)
    {
        $suffix = '@oaserver.dw.gdbbk.com';
        if (strpos($data['email'],$suffix) === false){
            $data['email'] = $data['email'].$suffix;
        }
        return $data;
    }

}
