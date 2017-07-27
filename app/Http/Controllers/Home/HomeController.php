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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Updatelogs::find(1);
        return view('welcome',['data'=>$data]);
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
