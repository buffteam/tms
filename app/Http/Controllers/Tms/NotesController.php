<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\BaseController;
use App\Model\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotesController extends BaseController
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function add () {
        // 验证
        $rules =  [
            'title' => 'required|max:80',
            'f_id' => 'required|max:10'
        ];

        $validator = Validator::make($this->request->all(), $rules);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(),'参数验证输错');
        }
        $params = $this->request->input();
        $exist = Notes::where(array('title'=>$params['title'],'f_id'=>$params['f_id']))->first();
        if (!empty($exist)) {
            return $this->responseError('笔记名称重复','参数验证输错');
        }
        $params['u_id'] = session('user')['uid'];

        if(!isset($params['parent_id'])) {
            $params['parent_id'] = 0;
        }
        Notes::create($params);
        return $this->setMsg('新增成功')->response();
    }
    public function del () {
        // 验证规则
        $rules =  [
            'id' => 'required|max:10'
        ];

        $validator = Validator::make($this->request->all(), $rules);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(),'参数验证输错');
        }
        $params = $this->request->input();

        Notes::where('id',$params['id'])->update(array('active'=>0));

        return $this->setMsg('删除成功')->response();

    }
    public function update () {
        // 验证
        $rules =  [
            'id' => 'required|max:10',
            'f_id' => 'required|max:10'
        ];

        $validator = Validator::make($this->request->all(), $rules);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(),'参数验证输错');
        }
        $params = $this->request->input();
        if (isset($params['title'])) {
            $exist = Notes::where(array('title'=>$params['title'],'f_id'=>$params['f_id']))->first();
            if (!empty($exist)) {
                return $this->responseError('笔记名称重复','参数验证输错');
            }
        }


        $params['u_id'] = session('user')['uid'];
        Notes::where(array('id'=>$params['id'],'f_id'=>$params['f_id']))->update($params);
        return $this->setMsg('修改成功')->response();
    }
    public function find () {
//        $id = $this->request->input('id');
//        Notes::where('id',$id)->update(['active'=>0]);
//        return $this->setMsg('修改成功')->response();
    }
    public function listAll () {
        return Notes::where('active',1)->get();
    }
}
