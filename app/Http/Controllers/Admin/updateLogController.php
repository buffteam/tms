<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Model\Updatelogs;
use Illuminate\Http\Request;

class updateLogController extends BaseController
{
    //
    public function index ()
    {
        $list = Updatelogs::all();
        return view('admin.update.index',['list'=>$list]);
    }

    public function create ()
    {
        return view('admin.update.create');
    }

    public function store (Request $request)
    {
        $this->validate($request,[
                'title'=>'required|max:50',
                'version'=>'required|max:30',
                'content-markdown-doc'=> 'required',
                'type' => 'required'
            ]
        );
        $params = $request->input();
        $data = [
            'title' => $params['title'],
            'type' =>  intval($params['type']),
            'version' => $params['version'],
            'md_doc' => $params['content-markdown-doc'],
            'html_doc' => $params['content-html-code']
        ];
        Updatelogs::create($data);
        return redirect(url('updateLog/index'));
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $data = Updatelogs::find($id);
        return view('admin.update.detail',['data'=>$data]);
    }

    public function update(Request $request)
    {
        $params = $request->input();
        $id = $params['id'];
        $data = Updatelogs::find($id);
        $data->update($params);
        return redirect(url('updateLog/index'));
    }
}
