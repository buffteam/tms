<?php

namespace App\Http\Controllers\Notes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Model\Folder;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class FolderController extends BaseController
{
    /**
     * 创建文件夹
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 验证规则
        $rules =  [
            'title' => 'required|max:80',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ajaxError('参数验证输错',$validator->errors());
        }
        $params = $request->input();

        // 只有管理员才有权限创建一级菜单
        if (user()->auth != 2 &&  $params['p_id'] == 0) {
            return $this->ajaxError('创建失败，没有权限创建一级菜单');
        }

        $num = Folder::where(['title'=>$params['title'],'p_id'=>$params['p_id']])->count();
        if ($num > 0) {
            return $this->ajaxError('文件夹名称重复');
        }
        $params['u_id'] = user()->id;
        $data = Folder::create($params);
        if (null != $data) {
            return $this->ajaxSuccess('新增成功',$data);
        }
        return $this->ajaxError('新增失败');
    }

    /**
     * 列表
     * @return array
     */
    public function listAll()
    {
        $list = Folder::all();
        $categories = [];//Folder::where(array('p_id'=>0))->select('id','title','p_id')->get();
        $allCategories = [];//Folder::where([['p_id','>',0]])->select('id','title','p_id','u_id')->get();
        foreach($list as $items) {
            // 开始处理显示目录下的文件数量
            $totalCount = 0;//文件夹及其所属的子文件下笔记总数量
            $items->currentCount = $items->notes()->count();// 当前文件夹下笔记数量
            $totalCount = $totalCount + $items->currentCount;
            $subCondition = Folder::where('p_id',$items->id);
            $subMenuCount = $subCondition->count();
            if ($subMenuCount > 0) {
                $delSubCount = $this->dealSub($subCondition->get());
                $totalCount = $totalCount + $delSubCount;
            }
            if ($items->p_id == 0) {
                $items->totalCount = $totalCount;
            }
            // 这里分流数据分为一级目录和其他目录
            if ($items->p_id == 0) {
                array_push($categories,$items->toArray());
            } else {
                array_push($allCategories,$items->toArray());
            }
        }
        return $this->ajaxSuccess('请求成功',compact('categories','allCategories'));
    }

    /**
     * 更新数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        // 验证规则
        $rules =  [
            'title' => 'required|max:50',
            'id' => 'required|max:11',
            'pid' => 'required|max:11'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ajaxError('参数验证输错',$validator->errors());
        }
        $params = $request->input();
        if (Auth::user()->auth != 2 && $params['pid'] == 0) {
            return $this->ajaxError('没有权限更改一级菜名称');
        }
        $exist = Folder::where(array('p_id'=>$params['pid'],'title'=>$params['title']))->count();
        if ($exist > 0) {
            return $this->ajaxError('文件夹名称重复');
        }
        $flag = Folder::where('id',$params['id'])->update(array('title'=>$params['title']));
        if (1 != $flag) {
            return $this->ajaxError('修改失败');
        }
        return $this->ajaxSuccess('修改成功',Folder::find($params['id']));
    }

    /**
     * 删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request)
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
        $Folder = Folder::find($params['id']);

        if (null === $Folder) {
            return $this->ajaxError('数据不存在');
        }

        if ($Folder->notes()->count() > 0) {
            return $this->ajaxError('删除失败，必须删除文件夹下所有笔记');
        }

        if (Folder::where('p_id',$params['id'])->count() > 0) {
            return $this->ajaxError('删除失败，必须删除该文件夹下面的子文件夹');
        }

        if ( $Folder->p_id === 0 && user()->auth !== 2 ) {
            return $this->ajaxError('删除失败，没有权限删除一级菜单');
        }

        if (!( user()->auth == 2 || $Folder->u_id ==  user()->id)) {
            return $this->ajaxError('删除失败,没有权限删除此文件夹');
        }

        $flag = $Folder->where('id',$params['id'])->update(array('active'=> '0'));
        if (1 != $flag) {
            return $this->ajaxError('删除失败');
        }

        return $this->ajaxSuccess('删除成功');

    }
    /**
     * 处理子菜单
     * @param $data
     * @return int
     */
    function dealSub($data) {
        $totalCount = 0;
        foreach ($data as $subItems) {
            $subItems->currentCount = $subItems->notes()->count();
            $totalCount = $totalCount + $subItems->currentCount;
            $subCondition = Folder::where('p_id',$subItems->id);
            $subMenuCount = $subCondition->count();
            if ($subMenuCount > 0) {
                $subMenu = $subCondition->get();
                $totalCount = $totalCount + $this->dealSub($subMenu);
            }
        }
        return $totalCount;
    }
}
