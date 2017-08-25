<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\BaseController;
use App\Model\Notes;
use App\Model\Share;
use Illuminate\Http\Request;

class ShareController extends BaseController
{
    /**
     * 我的分享
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $params = $request->input();
        $params['page']  = isset($params['page'] ) ?: 1;
        // 每页数量
        $params['pagesize'] = isset($params['pagesize']) ? $params['pagesize'] : config('page.pagesize');
        // 起始页
        $start = $params['page'] == 1 ? 0 : ($params['page']-1)*$params['pagesize'];
        $data = Share::where('u_id',user()->id)->skip($start)->take($params['pagesize'])->get();
        return $this->ajaxSuccess('获取成功',$data);
    }

    /**
     * 增加分享
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function share ($id)
    {
        $note = Notes::find($id);

        if ($note == null) {
            return $this->ajaxError('该笔记不存在');
        }

        if ($note->share !== null){
            $result = $note->share->toArray();
            return  $this->ajaxSuccess('分享成功',['token'=>$result['token'],'time'=>$result['created_at'],'author'=>$result['author']]);
        }

        $userId = user()->id;

        if ( !($note->u_id == $userId  || isAdmin() || $note->lock == 0) ) {
            return $this->ajaxError('没有权限分享');
        }

        $data['token'] = str_random(16);
        $data['note_id'] = $id;
        $data['u_id'] = user()->id;
        $data['author'] = user()->name;
        $flag = Share::create($data);
        $result = $flag->toArray();

        return $result ? $this->ajaxSuccess('分享成功',['token'=>$result['token'],'time'=>$result['created_at'],'author'=>$result['author']]) : $this->ajaxError('分享失败');

    }

    /**
     * 获取分享的详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $token = $request->input('token');
        $share = Share::where('token',$token)->first();
        $note = $share->note->toArray();
        $shareData = collect($share)->toArray();
        $data['title'] = $note['title'];
        $data['content'] = $note['content'];
        $data['origin_content'] = $note['origin_content'];
        $data['share_time'] = $shareData['created_at'];
        $data['author'] = $shareData['author'];
        return $this->ajaxSuccess('获取成功',$data);
    }

    /**
     * 取消分享
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($id)
    {
        $note = Notes::find($id);
        if ($note->share == null) {
            return $this->ajaxError('数据不存在');
        }
        $share = $note->share->delete();
        return $this->ajaxSuccess('取消成功',$share);
    }


}
