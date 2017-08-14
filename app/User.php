<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','auth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * 获取关联到用户的创建的笔记
     */
    public function notes()
    {
        return $this->hasMany('App\Model\Notes','u_id');
    }

    /**
     * 用户创建的群组
     */
    public function groups()
    {
        return $this->hasMany('App\Model\Groups','u_id');
    }
}
