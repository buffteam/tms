<?php

namespace App\Http\Controllers\Notes;

use App\Http\Traits\NotesTrait;
use App\Model\Folder;
use App\Model\Notes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class NotesController extends BaseController
{
    use NotesTrait;
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
        $validateData = $this->validateData($request->all());
        if (true !== $validateData) {
            return $validateData;
        }

        $params = $request->input();
        $isPrivate = null;
        if (!$request->has('f_id')) {
            $params['f_id'] = $this->findFid();
            $isPrivate = true;
        }

        if (null !== $isPrivate) {
            $isPrivate =  $this->checkFolderIsPrivate($params['f_id']);
        }



        $params['lock'] = $isPrivate ? 0 : 1;
        $params['isPrivate'] = $isPrivate ? '0' : '1';
        $data = $this->insertNote($params);

        return (null != $data) ? $this->ajaxSuccess('新增成功',$data) : $this->ajaxError('新增失败');

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
            return $this->ajaxError('参数验证输错',$validator->errors());
        }

        // 用户提交信息
        $params = $request->input();

        // 判断查询文件夹ID是否存在
        if (!$this->findFolderId($params['id'])) {
            return $this->ajaxError('文件夹ID不存在');
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
        // TODO 私人可见笔记待做 查询数据
        $folder = Folder::where('p_id',$params['id'])->get()->toArray();

        $list = Notes::where([ 'f_id'=>$params['id'] ])->isPrivate()
                    ->join('users','notes.u_id','=','users.id')
                    ->select('notes.*', 'users.name as author')
                    ->skip($start)
                    ->take($params['pagesize'])
                    ->orderBy($params['field'],$params['order'])
                    ->get();
        $totalPage = ceil($this->notesModel->count()/$params['pagesize']);
        return $this->ajaxSuccess('获取数据成功',array('totalPage'=>$totalPage,'data'=>$list,'folders'=>$folder));
    }

    /**
     * 获取笔记详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find (Request $request)
    {
        if (!$request->has('id')) {
            return $this->ajaxError('请传入ID');
        }
        if (!$request->has('active')) {
            return $this->ajaxError('请传入active');
        }
        $params = $request->input();
        $data = Notes::withoutGlobalScopes()->where('active',$params['active'])
            ->leftJoin('users','notes.u_id','=','users.id')
            ->select('notes.*', 'users.name as author')
            ->find($params['id']);

        if (null != $data) {
            return $this->ajaxSuccess('获取成功',$data);
        }
        return $this->ajaxError('数据不存在');

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
            'f_id' => 'required',
            'title' => 'required',
            'content' => 'max:'.(pow(2,32)-10),
            'origin_content' => 'max:'.(pow(2,32)-10)
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ajaxError('参数验证输错',$validator->errors());
        }

        $params = $request->input();

        $isPrivate = $this->checkFolderIsPrivate($params['f_id']);

        if (!$isPrivate && $this->isLocked($params['id'])) {
            return $this->ajaxSuccess('保存失败，此笔记已经被创建人锁住,不允许修改');
        };
        $updateData = $this->updateData($params);
        if ($updateData != 1) {
            return $this->ajaxError('更新失败，数据不存在');
        }
        return $this->ajaxSuccess('更新成功',Notes::find($params['id']));
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
            return $this->ajaxError('参数验证输错',$validator->errors());
        }
        $params = $request->input();
        $user = user();
        $note = Notes::find($params['id']);

        if (!($user->auth == 2 || $note->u_id == $user->id)) {
            return $this->ajaxError('删除失败,没有权限删除此笔记');
        }


        $data = Notes::where('id',$params['id'])->update(array('active'=>'0','last_updated_name'=>user()->name));

        return ($data != 1) ? $this->ajaxError('数据在另一端已经被删除了，请刷新页面') : $this->ajaxSuccess('删除成功');

    }

    /**
     * 最新文档
     * @return \Illuminate\Http\JsonResponse
     */
    public function latest ()
    {
        $latest = $this->getLatest();
        return $this->ajaxSuccess('获取成功',$latest);
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
            return $this->ajaxError('参数验证输错',$validator->errors());
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

        // 选择搜索字段
        $params['type'] = isset($params['type']) ? $params['type'] : 'name';



        // 第一步查询出总页数
        $noteModel = $this->notesModel;
        // 起始页
        $start = $params['page'] == 1 ? 0 : ($params['page']-1)*$params['pagesize'];

        // 查询title页数 如果不足就查询匹配content的内容补足
//        $titleCondition = [[$params['type'],'like','%'.$params['keywords'].'%']];
        $titleCondition = [];
        if ($params['type'] == 'name') {
            $user = DB::table('users')->where('name',$params['keywords'])->first();
            if (null !== $user) {
                $titleCondition = [['u_id',$user->id]];
            } else {
                return $this->ajaxSuccess('搜索成功',['totalPage'=>0,'data'=>[]]);
            }

        } else {
            $titleCondition = [[$params['type'],'like','%'.$params['keywords'].'%']];
        }

        $titleCount = $noteModel->getCountByCondition($titleCondition);

        $totalPage = ceil($titleCount/$params['pagesize']);

        $list = $noteModel->where($titleCondition)
            ->join('users','notes.u_id','=','users.id')
            ->select('notes.*', 'users.name as author')
            ->offset($start)
            ->orderBy($params['field'],$params['order'])
            ->limit($params['pagesize'])
            ->get()->toArray();

        return $this->ajaxSuccess('搜索成功',['totalPage'=>$totalPage,'data'=>$list]);
    }



    /**
     * 获取回收站列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecycle ()
    {
        // 分页页码
        $params['page'] = isset($params['page']) ? $params['page'] : 1;

        // 每页数量
        $params['pagesize'] = isset($params['pagesize']) ? $params['pagesize'] : $this->pagesize;

        $condition = Notes::withoutGlobalScopes()->where('active','0');

        $totalNum = $condition->count();

        $totalPage = ceil($totalNum/$params['pagesize']);

        // 起始页
        $start = $params['page'] == 1 ? 0 : ($params['page']-1)*$params['pagesize'];

        $list = $condition->join('users','notes.u_id','=','users.id')
                ->select('notes.*', 'users.name as author')
                ->skip($start)->take($params['pagesize'])->get();

        return $this->ajaxSuccess('获取数据成功',['totalPage'=>$totalPage,'$totalCount'=>$totalNum,'data'=>$list]);

    }

    /**
     * 恢复笔记
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recoveryNote (Request $request)
    {
        if (!$request->has('id')) {
            return $this->ajaxError('参数ID未传');
        }
        $id = $request->input('id');

        $note = Notes::withoutGlobalScopes()->where('id',$id)->update(['active'=>'1']);

        return !$note ? $this->ajaxError('恢复失败,请刷新重试') : $this->ajaxSuccess('恢复成功');

    }

    /**
     * 启动锁
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function LockNote (Request $request)
    {
        $flag = $this->setLock($request,1);

        return $flag === true ? $this->ajaxSuccess('操作成功') : $flag;

    }

    /**
     * 解锁
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlockNote (Request $request)
    {
        $flag = $this->setLock($request,0);

        return $flag === true ? $this->ajaxSuccess('操作成功') : $flag;

    }

    /**
     * 设置锁
     * @param $request
     * @param int $status
     * @return bool|\Illuminate\Http\JsonResponse
     */
    protected function setLock ($request,$status = 0)
    {
        if (!$request->has('id')) {
            return $this->ajaxError('操作失败，参数不存在');
        }

        $id = $request->input('id');

        $notes = Notes::find($id);

        if (!$notes) {
            return $this->ajaxError('操作失败,参数错误');
        }

        if ( !(isAdmin() || $notes->u_id == user()->id) ) {
            return $this->ajaxError('操作失败,没有权限操作');
        }

        return  $notes->where('id',$id)->update(['lock'=>$status]) ? true : false;

    }

    /**
     * 获取锁值
     * @param $id
     * @return mixed
     */
    protected function isLocked ($id)
    {
        $lock = $this->notesModel->where('id',$id)->select('lock')->first();

        return $lock->lock == 1;
    }
}
