<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\BaseController;
use App\Model\Notes;
use App\Model\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShareController extends BaseController
{
    public function share ($id)
    {
//        dd($id);
        $note = Notes::find($id);

        if ($note == null) {
            return $this->ajaxError('该笔记不存在');
        }

        if ($note->share !== null){
            return $this->ajaxError('已经有了分享');
        }

        $userId = user()->id;

        if ( !($note->u_id == $userId  || isAdmin() || $note->lock == 0) ) {
            return $this->ajaxError('没有权限分享');
        }

        $data['token'] = str_random(16);
        $data['note_id'] = $id;
        $data['u_id'] = user()->id;
        $flag = Share::create($data);
        $result = $flag->toArray();
        return $result ? $this->ajaxSuccess('分享成功',['token'=>$result['token'],'time'=>$result['created_at']]) : $this->ajaxError('分享失败');

    }
}
