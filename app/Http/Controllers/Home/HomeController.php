<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Model\Updatelogs;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Updatelogs::all();
        $desc = [];
        $logs = [];
        $version = [];
        foreach ($list as $item) {

            if ($item->type == 2) {
                array_push($desc,$item);
            } else if ($item->type == 1) {
                array_push($logs,$item);
            } else {
                array_push($version,$item);
            }
        }
        return view('welcome',['data'=>compact('desc','logs','version')]);
    }
    public function updateLog()
    {
        $data = Updatelogs::where('id','>',1)->get();
        $str = '';
        foreach ($data as $item) {
            $str = $str.$item->html_doc;
        }
        return response()->json(['content'=>$str]);
    }
}
