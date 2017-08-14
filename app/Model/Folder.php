<?php

namespace App\Model;

use App\Scopes\PublicScope;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'folders';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = true;
    protected $fillable = ['title','u_id','p_id','active','g_id','type'];
//    protected $guarded = ['created_at','updated_at'];
    /**
     * 添加全局条件
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PublicScope);
    }

    /**
     * 一个文件夹拥有多个笔记
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany('App\Model\Notes','f_id','id');
    }

    /**
     * 一个文件夹属于一个唯一的群组
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Model\Groups','g_id','id');
    }
}
