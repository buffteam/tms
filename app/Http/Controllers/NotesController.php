<?php

namespace App\Http\Controllers;
use App\Folder;
use App\Notes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class NotesController extends BaseController
{
    /**
     * 每页显示数量
     */
    protected $pagesize;
    /**
     * 模型
     */
    protected $notesModel;

    public function __construct()
    {
        $this->pagesize = config('page.pagesize');
        $this->notesModel = new Notes();
    }

    /**
     * 新增笔记
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add (Request $request)
    {
        // 验证规则
        $rules =  [
            'title' => 'required',
            'f_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->error('参数验证输错',$validator->errors());
        }
        $params = $request->input();

        //TODO 验证关联表 某个数据是否存在表数据中
        if (!$this->findFolderId($params['f_id'])) {
            return $this->error('文件夹ID不存在');
        }
//        DB::connection()->enableQueryLog();
        $count = $this->notesModel->like('title',$params['title'])->where(['f_id'=>$params['f_id']])->count();
//        $log = DB::getQueryLog();
//        dd($log);
//        dump($count);
//        exit();
        if ($count > 0) {
            $params['title'] = $params['title'].'('.$count.')';
        }
        $params['u_id'] = user()->id;

        $data = $this->notesModel->create($params);
        return $this->success('新增成功',$data);

    }

    /**
     * 获取id下面的笔记
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show (Request $request)
    {
        // 验证规则
        $rules =  [
            'id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->error('参数验证输错',$validator->errors());
        }

        // 用户提交信息
        $params = $request->input();

        // 判断查询文件夹ID是否存在
        if (!$this->findFolderId($params['id'])) {
            return $this->error('文件夹ID不存在');
        }

        // 选择排序字段
        $params['field'] = isset($params['field']) ? $params['field'] : 'created_at';

        // 选择排序方式
        $params['order'] = isset($params['order']) ? $params['order'] :  'desc';

        // 分页页码
        $params['page'] = isset($params['page']) ? $params['page'] : 1;

        // 每页数量
        $params['pagesize'] = isset($params['pagesize']) ? $params['pagesize'] : $this->pagesize;
        // 起始页
        $start = $params['page'] == 1 ? 0 : ($params['page']-1)*$params['pagesize'];

        // 获取用户ID
//        $userId = user()->id;
        // TODO 私人可见笔记待做 查询数据
//        $private = $this->notesModel->isPrivate('0')->where([ 'u_id'=>$userId,'f_id'=>$params['id']]);


        $list = $this->notesModel->isPrivate()->where([ 'f_id'=>$params['id'] ])
//                    ->union($private)
                    ->orderBy($params['field'],$params['order'])
                    ->offset($start)
                    ->limit($params['pagesize'])
                    ->get()->toArray();

        $totalPage = ceil($this->notesModel->count()/$params['pagesize']);
        return $this->success('获取数据成功',array('totalPage'=>$totalPage,'data'=>$list));
    }

    /**
     * 获取笔记详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find (Request $request)
    {
        $id = $request->input('id');
        $data = Notes::find($id);
        return $this->success('获取成功',$data);

    }

    /**
     * 更新笔记
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update (Request $request)
    {
        // 验证
        $rules =  [
            'id' => 'required',
            'f_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->error('参数验证输错',$validator->errors());
        }

        $params = $request->input();
        if (isset($params['title'])) {
            $count = $this->notesModel->like('title',$params['title'])
                ->where(['f_id'=>$params['f_id']])
                ->where('id','!=',$params['id'])
                ->count();
            if ($count > 0) {
                $params['title'] = $params['title'].'('.($count+1).')';
            }
        }


        $params['updated_id'] = user()->id;

        $data = $this->notesModel->where(array('id'=>$params['id'],'f_id'=>$params['f_id']))->update($params);
        if ($data != 1) {
            return $this->success('更新失败');
        }
        return $this->success('更新成功',Notes::find($params['id']));
    }

    /**
     * 删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del (Request $request)
    {
        // 验证规则
        $rules =  [
            'id' => 'required|max:10'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->error('参数验证输错',$validator->errors());
        }
        $params = $request->input();

        $data = Notes::where('id',$params['id'])->update(array('active'=>'0'));
        if ($data != 1) {
            return $this->success('删除失败');
        }
        return $this->success('删除成功');

    }

    /**
     * 最新文档
     * @return \Illuminate\Http\JsonResponse
     */
    public function latest ()
    {
        $latest = $this->notesModel->isPrivate()->limit($this->pagesize)->get();
        return $this->success('获取成功',$latest);
    }

    /**
     * 搜索
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // 验证规则
        $rules =  [
            'keywords' => 'required|max:80',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->error('参数验证输错',$validator->errors());
        }
        $params = $request->input();

        // 选择排序字段
        $params['field'] = isset($params['field']) ? $params['field'] : 'created_at';

        // 选择排序方式
        $params['order'] = isset($params['order']) ? $params['order'] :  'desc';

        // 分页页码
        $params['page'] = isset($params['page']) ? $params['page'] : 1;

        // 每页数量
        $params['pagesize'] = isset($params['pagesize']) ? $params['pagesize'] : $this->pagesize;
        // 起始页
        $start = $params['page'] == 1 ? 0 : ($params['page']-1)*$params['pagesize'];

        $list = $this->notesModel->isPrivate()->where('title','like','%'.$params['keywords'].'%')
                    ->orderBy($params['field'],$params['order'])
                    ->offset($start)
                    ->limit($params['pagesize'])
                    ->get();
        $totalNum = $this->notesModel->where('title','like','%'.$params['keywords'].'%')->count();
        $totalPage = ceil($totalNum/$params['pagesize']);
        return $this->success('搜索成功',['totalPage'=>$totalPage,'data'=>$list]);
    }

    /**
     * 验证文档Id是否存在
     * @param $id
     * @return bool
     */
    private function findFolderId($id)
    {
        return Folder::find($id) ? true : false;
    }
}
