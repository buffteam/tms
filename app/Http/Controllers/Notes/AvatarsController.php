<?php

namespace App\Http\Controllers\Notes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Model\Avatars;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Libs\upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarsController extends BaseController
{
    /**
     * 显示头像列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {

        $userId = Auth::user()->id;
        return view('auth.avatar',['list'=>$this->findAvatars($userId)]);
    }

    /**
     * 上传头像
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload(Request $request)
    {
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('avatar')){
            return back()->withErrors([['avatar'=>'上传文件为空！']]);
        }
        $file = $request->file('avatar');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            return back()->withErrors([['avatar'=>'文件上传出错！']]);
        }
        $user = Auth::user();
        $uploadPath = 'uploads/avatar/'.$user->id.'/';
        if(!file_exists($uploadPath)) {
            mkdir($uploadPath,0777,true);
        }
        $renameFilename = $this->getUniName().'.'.$file->getClientOriginalExtension();
        $flag = $file->move($uploadPath,$renameFilename);
        if(!$flag){
            return back()->withErrors([['avatar'=>'保存文件失败！']]);
        }
        // 插入头像表
        $status = $this->insertAvatar($uploadPath.$renameFilename,$user->id);

        return view('auth.avatar',['list'=>$this->findAvatars($user->id),'status'=>$status]);

    }

    /**
     * 插入头像
     * @param $url
     * @param $userId
     * @return string
     */
    public function insertAvatar ($url,$userId)
    {
        return Avatars::create(['url'=>$url,'u_id'=>$userId,'active'=>0]) ? '上传成功' : '上传失败';
    }

    /**
     * 获取用户上传的头像列表
     * @param $userId
     * @return mixed
     */
    public function findAvatars ($userId)
    {
        return Avatars::whereIn('u_id',[$userId,0])->get();
    }

    /**
     * 设置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectAvatar (Request $request)
    {
        if (!$request->has('url')) {
            return $this->ajaxError('参数不正确');
        }
        $params = $request->input();
        $user = $request->user();
//        Avatars::where('url',$params['url'])->where('u_id',$user->id)->get();
        $avatar = Avatars::find($params['id']);
        if ($avatar->active == 1) {
            return $this->ajaxError('该图片已是头像');
        }
        // 让之前的头像失效
        $this->setFailure($user->id);


        // 激活当前头像
        $this->setActive($params['url']);

        // 保存头像至用户信息中去
        $user->avatar = $params['url'];
        $flag = $user->save();

        return $this->ajaxSuccess('设置成功',$flag);
    }

    /**
     * 激活头像
     * @param $url
     */
    protected function setActive($url)
    {
        return Avatars::where('url',$url)->update(['active'=>1]);
    }
    /**
     * 设置头像失活
     * @param $userId
     */
    protected function setFailure($userId)
    {
        return Avatars::where('u_id',$userId)->where('active',1)->update(['active'=>0]);
    }

    public function deleteAvatar (Request $request)
    {
        $rules =  [
            'id' => 'required',
            'url' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ajaxError('参数验证输错',$validator->errors());
        }
        $params = $request->input();

        // 第一步删除数据地址，第二部删除存储器中文件
        $flag = Avatars::where('active',0)->where('id',$params['id'])->delete();
        if (!$flag) {
            return $this->ajaxError('删除失败，当前头像不允许删除');
        }
        $delFile = unlink($params['url']);
        if (!$delFile) {
            return $this->ajaxError('删除失败');
        }
        return $this->ajaxSuccess('删除成功');
    }

    /**
     * 产生随机名字
     * @return string
     */
    protected function getUniName()
    {
        return md5(uniqid(microtime(true), true));
    }
}
