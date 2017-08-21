<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Model\Notes;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Folder;
class DashboardController extends BaseController
{
    //
    public function index ()
    {
        return view('admin.index');
    }


    public function getNotesClass ()
    {
        $list = Folder::where('g_id',1)->where('p_id',0)->get();
        $listAll = Folder::all();
        $categories = [];//Folder::where(array('p_id'=>0))->select('id','title','p_id')->get();
        foreach($list as $items) {

            // 开始处理显示目录下的文件数量
            $totalCount = 0;//文件夹及其所属的子文件下笔记总数量
            $items->currentCount = $items->notes()->count();// 当前文件夹下笔记数量
            $totalCount = $totalCount + $items->currentCount;
            $subCondition = Folder::where('p_id',$items->id);
            $subMenuCount = $subCondition->count();
            $items->name = $items->title;
            if ($subMenuCount > 0) {
                $delSubCount = $this->dealSub($subCondition->get());
                $totalCount = $totalCount + $delSubCount;
            }
            if ($items->p_id == 0) {
                $items->value = $totalCount;
            }
            // 这里分流数据分为一级目录和其他目录
            if ($items->p_id == 0) {
                array_push($categories,$items->toArray());
            }
        }
        return $this->ajaxSuccess('获取成功',$categories);
    }

    /**
     * 获取用户数量、笔记数量、回收站数量
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNumCount()
    {

        $users = DB::table('users')->count();
        $notesCount = DB::table('notes')->where('active','1')->count();
        $recycleCount = DB::table('notes')->where('active','0')->count();
        return $this->ajaxSuccess('获取成功',['userTotal'=>$users,'notesTotal'=>$notesCount,'recycleCount'=>$recycleCount]);

    }

    public function getRankingList()
    {
        $list = DB::select('SELECT u.name,COUNT(*) AS num FROM stip_users u RIGHT JOIN stip_notes n ON u.id = n.u_id where n.active = "1" GROUP BY u.name ORDER BY num desc limit 10');
        return $this->ajaxSuccess('获取榜单数据成功',$list);
    }

    /**
     * 处理子菜单
     * @param $data
     * @return int
     */
    protected function dealSub($data) {
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
