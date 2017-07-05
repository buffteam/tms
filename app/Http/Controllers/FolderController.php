<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Folder;
class FolderController extends BaseController
{
    protected $folder;
    protected $request;
    public function __construct(Request $request)
    {
        $this->folder = DB::table('folder');
        $this->request = $request;
    }

    //
    public function store()
    {
        // 验证规则
        $rules =  [
            'title' => 'required|max:30',
        ];
        $request = $this->request;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->error('参数验证输错',$validator->errors());
        }
        $params = $request->input();
        $folder = $this->folder;
        $exist = $folder->where('title',$params['title'])->first();
        if (!empty($exist)) {
            return $this->error('文件夹名称重复');
        }
        $params['u_id'] = user()->auth;
//
        if(!isset($params['parent_id'])) {
            $params['parent_id'] = 0;
        }
        $id = $folder->insertGetId($params);
        return $this->success('新增成功',array('id'=>$id));
    }

    /**
     * @return array
     */
    public function listAll()
    {
        //
        $categories = $this->folder->where(array('parent_id'=>0,'active'=>1))->select('id','title','parent_id')->get();
        $allCategories = $this->folder->where([['parent_id','>',0],['active','=',1]])->select('id','title','parent_id','u_id')->get();
        return $this->success('请求成功',compact('categories','allCategories'));
    }


    public function modify()
    {
        DB::connection()->enableQueryLog();
        // 验证规则
        $rules =  [
            'title' => 'required|max:30',
            'id' => 'required|max:10'
        ];
        $request = $this->request;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->error('参数验证输错',$validator->errors());
        }
        $params = $request->input();
        $folder = DB::table('folder');
        $pid = isset($params['pid']) ? $params['pid'] : 0;
        $exist = $folder->where(array('parent_id'=>$pid,'title'=>$params['title']))->first();
        if (!empty($exist)) {
            return $this->error('文件夹名称重复');
        }
        $flag = $folder->where('id',$params['id'])->update(array('title'=>$params['title']));
        $queries = DB::getQueryLog(); // 获取查询日志

        var_dump($queries); // 即可查看执行的sql，传入的参数等等
        if ($flag == 1) {
            return $this->success('修改成功');
        }
        return $this->error('修改失败');
    }


    public function del()
    {
        // 验证规则
        $rules =  [
            'id' => 'required|max:10'
        ];
        $request = $this->request;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->error('参数验证输错',$validator->errors());
        }
        $params = $request->input();
        $pid = $this->folder->where('id',$params['id'])->select('parent_id as pid')->first();
        if ($pid->pid === 0 && user()->auth !== 2) {
            return $this->error('没有权限删除一级菜单');
        }
        dump($params);
        $flag = $this->folder->where('id',$params['id'])->update($params);
        if ( $flag == 1 ){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');

    }
}
