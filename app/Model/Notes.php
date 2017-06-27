<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    //
    protected $table = 'notes';
    //可填充的字段
    public $fillable = ['title','content','u_id','f_id','type','isPrivate','active'];

    // 将新增时间和修改时间以时间戳的方式进行管理
    protected function getDateFormat(){
        return time();
    }
}
