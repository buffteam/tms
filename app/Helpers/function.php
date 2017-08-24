<?php
/**
 * Created by PhpStorm.
 * User: freddy
 * Date: 2017/6/24
 * Time: 11:25
 */


if(! function_exists('user')){

    /**
     * @param null $driver
     * @return mixed
     */
    function user($driver = null){
        if($driver){
            return app('auth')->guard($driver)->user();
        }
        return app('auth')->user();
    }
}
if(! function_exists('isAdmin')){

    function isAdmin(){
        return user()->auth == 2;
    }
}
if(! function_exists('U')){

    /**
     * @param string $msg
     * @param $route
     * @param int $time
     * @param bool $type
     * @return \Illuminate\Http\RedirectResponse
     */
    function U($msg = '默认提示信息', $route = 'root',$time = 2 ,$type = true){
        return redirect(route('prompt'))->with([$msg,'url' =>route($route), 'jumpTime'=>$time,'status'=>$type]);
    }
}

