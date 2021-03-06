<?php
/**
 * Created by PhpStorm.
 * User: freddy
 * Date: 2017/8/9
 * Time: 10:41
 */

namespace App\Http\Traits;
use App\Model\Folder;
use Illuminate\Support\Facades\Validator;
trait CreateFolders
{
    /**
     * 验证插入
     * @param array $data
     * @return bool|\Illuminate\Http\JsonResponse
     */
    protected function validateData (array $data)
    {
        // 验证规则
        $rules =  [
            'title' => 'required|max:80',
            'g_id' => 'required',
            'type' => 'required',
            'p_id' => 'required'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $this->ajaxError('参数验证输错',$validator->errors());
        }
        return true;
    }

    /**
     * 插入文件夹
     * @param $params
     * @return \Illuminate\Http\JsonResponse
     */
    protected function insertFolder ($params)
    {
        // 群组下面 没有
        $num = Folder::where('p_id',$params['p_id'])->where('u_id',user()->id)->where('title','like','%'.$params['title'].'%')->count();

        if ($num > 0) {
            $params['title'] = $params['title'].'('.$num.')';
        }

        $params['u_id'] = user()->id;

        return Folder::create($params);

    }
}