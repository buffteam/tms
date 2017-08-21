<?php

namespace App\Http\Controllers\Notes;

use App\Model\Groups;
use Illuminate\Support\Facades\Validator;
use App\Model\Folder;
use Illuminate\Http\Request;
use App\Http\Traits\CreateFolders;
use App\Http\Controllers\BaseController;

class FolderController extends BaseController
{
    use CreateFolders;
    /**
     * 创建文件夹
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 验证规则
        $validateData = $this->validateData($request->all());
        if (true !== $validateData) {
            return $validateData;
        }
        $params = $request->input();
        $data = null;
        // 创建私人群组的文件夹
        if ($params['type'] == 0) {
            $data = $this->insertFolder($params);
        }
        // 创建公开群组的文件夹
        else {

            if (user()->auth != 2 ) {// 只有管理员才有权限创建一级菜单
                return $this->ajaxError('只有管理员才有权限创建菜单');
            }
            $data = $this->insertFolder($params);
        }

        return (null !== $data) ? $this->ajaxSuccess('新增成功',$data) : $this->ajaxError('新增失败');

    }

    /**
     * 获取群组和文件夹
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroups()
    {
        $list = Groups::where('u_id',user()->id)->orWhere('type',1)->orderBy('id','desc')->get();
        $result = [];

        foreach ($list as $item) {
            if ($item->folders) {

                foreach ($item->folders as $folder) {
                    $totalCount = 0;
                    $folder->currentCount = $folder->notes->count();
                    $totalCount = $totalCount + $folder->currentCount;
                    $subCondition = Folder::where('p_id',$folder->id);
                    $subMenuCount = $subCondition->count();
                    if ($subMenuCount > 0) {
                        $delSubCount = $this->recursion($subCondition->get());
                        $totalCount = $totalCount + $delSubCount;
                    }
                    // 返回数据中加上笔记总数
                    if ($folder->p_id == 0) {
                        $folder->totalCount = $totalCount;
                    }
                    unset($folder->notes);
                }
                array_push($result,$item->toArray());
            }
        }
        return $this->ajaxSuccess('请求成功',$result);
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

        $Folder = Folder::find($params['id']);
        if ( !(isAdmin() || user()->id == $Folder->u_id) ) {
            return $this->ajaxError('没有权限更改菜单名称');
        }
        // 群组下面 没有
        $num = Folder::where('p_id',$params['pid'])->where('title','like','%'.$params['title'].'%')->count();

        if ($num > 1) {
            $params['title'] = $params['title'].'('.$num.')';
        }
        $flag = $Folder->update(array('title'=>$params['title']));
        if (1 != $flag) {
            return $this->ajaxError('修改失败');
        }
        return $this->ajaxSuccess('修改成功',$Folder);
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
        $user = user();

        if (!($user->auth == 2 || $Folder->u_id == $user->id)) {
            return $this->ajaxError('删除失败,没有权限删除此文件夹');
        }

        $groupId = $Folder->group->id;

        $countFolder = $Folder->where('g_id',$groupId)->count();
        if ($countFolder === 1) {
            return $this->ajaxError('删除失败，只剩下唯一的文件夹不允许删除！');
        }
        if ($Folder->notes()->count() > 0) {
            return $this->ajaxError('删除失败，必须删除文件夹下所有笔记');
        }

        if (Folder::where('p_id',$params['id'])->count() > 0) {
            return $this->ajaxError('删除失败，必须删除该文件夹下面的子文件夹');
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
    function recursion($data) {
        $totalCount = 0;
        foreach ($data as $subItems) {
            $subItems->currentCount = $subItems->notes()->count();
            $totalCount = $totalCount + $subItems->currentCount;
            $subCondition = Folder::where('p_id',$subItems->id);
            $subMenuCount = $subCondition->count();
            if ($subMenuCount > 0) {
                $subMenu = $subCondition->get();
                $totalCount = $totalCount + $this->recursion($subMenu);
            }
        }
        return $totalCount;
    }
}
