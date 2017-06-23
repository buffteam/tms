<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * 关联到模型的数据表
     * @var string
     */
    protected $table = 'users';

    /**
     * 表明模型是否应该被打上时间戳
     * @var bool
     */
    public $timestamps = true;

    // 将新增时间和修改时间以时间戳的方式进行管理
    protected function getDateFormat(){
        return time();
    }
}
