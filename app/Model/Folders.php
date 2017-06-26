<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Folders extends Model
{
    //
    protected $table = 'folders';
    //可填充的字段
    public $fillable = ['title','u_id','parent_id','active'];

    // 将新增时间和修改时间以时间戳的方式进行管理
    protected function getDateFormat(){
        return time();
    }
}
