<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\BaseController;
use App\Model\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        //TODO 关联模型判断文件夹ID是否存在
        $exist = Notes::where(array('title'=>$params['title'],'f_id'=>$params['f_id']))->first();
        if (!empty($exist)) {
            return $this->responseError('笔记名称重复','参数验证输错');
        }
        $params['u_id'] = session('user')['uid'];

        if(!isset($params['type'])) {
            $params['type'] = 1;
        }

        $notes = Notes::create($params);

        return $this->setMsg('新增成功')->response($notes);
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
        $id = $this->request->input('id');
        $data = Notes::where('id',$id)->select(['id','title','content','f_id'])->get();
        return $this->setMsg('获取成功')->response($data);
    }

    public function show () {
        //TODO 分页 排序 时间转化
        $params = $this->request->input();
        $pagesize = isset($params['pagesize']) ? $params['pagesize'] : 15;
        $page = isset($params['page']) ? $params['page'] : 1;
        $start =  ($page - 1)*$pagesize + 1 ;

        $total = Notes::count();
        $totalPage = ceil($total/$pagesize);
        $start = ($page - 1)*$pagesize;
        $sql = 'select id,title,content,origin_content,u_id,f_id,type,isPrivate,updated_at from tms_notes where active > 0 and f_id ='.$params['id'].' ORDER BY updated_at DESC limit '.$start.','.$pagesize ;
        $data = DB::select($sql);
        return $this->setMsg('获取成功')->response(['totalPage'=>$totalPage,'data'=>$data]);
    }
    public function listAll () {
        return Notes::where('active',1)->get();
    }

    public function upload () {
        $request = $this->request;

        if (!$request->hasFile('file')) {
            //
            return $this->responseError('没有选择文件');
        }
        $file = $request->file('file');
        if (!$file->isValid()){
            //
            return $this->responseError('上传文件失败');
        }
        $path = $file->path();
//        return '<img src="'.$path.'">';
        dump($file);

    }
}
