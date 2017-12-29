<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Visitor extends Model
{
    protected $table = 'visitor';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['note_id','user_id'];

    public function visitor()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}
