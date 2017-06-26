<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\BaseController;
use App\Model\Folders;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FolderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('test/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('test/add');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 验证规则
        $rules =  [
            'title' => 'required|max:30',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(),'参数验证输错');
        }
        $params = $request->input();
        $exist = Folders::where('title',$params['title'])->first();
        if (!empty($exist)) {
            return $this->responseError('文件夹名称重复','参数验证输错');
        }
        $params['u_id'] = session('user')['uid'];

        if(!isset($params['parent_id'])) {
            $params['parent_id'] = 0;
        }
        Folders::create($params);
        return $this->setMsg('新增成功')->response();
    }

    /**
     * @return array
     */
    public function listAll()
    {
        //
        $categories = Folders::where(array('parent_id'=>0,'active'=>1))->select('id','title','parent_id')->get();
        $allCategories = Folders::where([['parent_id','>',0],['active','=',1]])->select('id','title','parent_id')->get();
        return $this->response(compact('categories','allCategories'));
    }

    /**
     * @param Request $request
     * @return array|bool
     */
    public function update(Request $request)
    {
        // 验证规则
        $rules =  [
            'title' => 'required|max:30',
            'id' => 'required|max:10'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(),'参数验证输错');
        }
        $params = $request->input();
        $exist = Folders::where('title',$params['title'])->first();
        if (!empty($exist)) {
            return $this->responseError('文件夹名称重复','参数验证输错');
        }

        Folders::where('id',$params['id'])->update($params);

        return $this->setMsg('修改成功')->response();
    }



    public function del(Request $request)
    {
        // 验证规则
        $rules =  [
            'id' => 'required|max:10'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(),'参数验证输错');
        }
        $params = $request->input();

        Folders::where('id',$params['id'])->update(array('active'=>0));

        return $this->setMsg('删除成功')->response();

    }
}
