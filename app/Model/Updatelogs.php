<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Updatelogs extends Model
{
    //
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'update_logs';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = true;
    protected $fillable = ['title','md_doc','html_doc','version'];
}
