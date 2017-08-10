<?php

namespace App\Http\Controllers\Notes;

use App\Model\Groups;
use Illuminate\Support\Facades\Auth;
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
        if ($params['active'] == 0) {
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

        $list = Groups::where('u_id',user()->id)->orWhere('type',1)->get();
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
        dd($result);
        return $this->ajaxSuccess('请求成功',$result);
    }

    /**
     * 列表
     * @return array
     */
    public function listAll($list)
    {
//        $list = Folder::all();

        $public = [
            'categories' => [],
            'allCategories' => []

        ];
        $private = [
            'categories' => [],
            'allCategories' => []
        ];

        $data = [];

        foreach($list as $index => $items) {

            // 开始处理显示目录下的文件数量

            //文件夹及其所属的子文件下笔记总数量
            $totalCount = 0;
//            $needFolder = $items->select('id','title','p_id','g_id')->first()->toArray();
            $data[$index] = [
                'id' => $items->id,
                'title' => $items->title,
                'p_id' => $items->p_id,
                'g_id' => $items->g_id,
                'currentCount' => $items->notes->count(),
//                'title' => $items->title,
//                'title' => $items->title
            ];
            // 当前文件夹下笔记数量
            $items->currentCount = $items->notes->count();
//            dd(array_push($data[$index],['currentCount'=>$items->currentCount]));
//            $data[$index] = ;
//            dd($data);
            // 计算总数量
            $totalCount = $totalCount + $items->currentCount;

            // 判断有么有没有子菜单
            $subCondition = Folder::where('p_id',$items->id);
            $subMenuCount = $subCondition->count();
            if ($subMenuCount > 0) {
                $delSubCount = $this->recursion($subCondition->get());
                $totalCount = $totalCount + $delSubCount;
            }
            // 返回数据中加上笔记总数
            if ($items->p_id == 0) {
                $items->totalCount = $totalCount;
            }
//            dd($items->get());
            // 这里分流数据分为一级目录和其他目录
            if ( $items->p_id == 0 ) {


                if ($items->group->type == 0) { // 公开目录

                    array_push($public['categories'],$items);


                } else if ($items->group->type == 1) { // 私有目录


                    array_push($private['categories'],$items);

                }

            } else { // 如果非一级目录

                if ($items->group->type == 0) {

                    array_push($public['allCategories'],$items);

                } else if ($items->group->type == 1) {

                    array_push($public['allCategories'],$items);

                }
            }

        }
        return $this->ajaxSuccess('请求成功',compact('public','private'));
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
        if (user()->auth != 2 ) {
            return $this->ajaxError('没有权限更改菜单名称');
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

        if ( user()->auth !== 2 ) {
            return $this->ajaxError('删除失败，没有权限删除一级菜单');
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
                $totalCount = $totalCount + $this->dealSub($subMenu);
            }
        }
        return $totalCount;
    }
}
