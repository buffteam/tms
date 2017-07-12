<?php

namespace App\Http\Controllers;

use App\Feeds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list = Feeds::all();
        return view('feedback.index',['list'=>$list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('feedback.create');
    }


    public function store(Request $request)
    {
        //
        $this->validate($request, [
                'title' => 'required|max:60',
                'content' => 'required|max:1000'
            ]);

        $params = $request->input();
        $params['ip'] = $request->ip();
        if (Auth::check()) {
            $params['user_id'] = Auth::id();
        }
        $flag = Feeds::create($params);
        if (null != $flag) {
            return redirect(route('root'));
        }
        return back()->withInput();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feeds  $feeds
     * @return \Illuminate\Http\Response
     */
    public function show(Feeds $feeds)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feeds  $feeds
     * @return \Illuminate\Http\Response
     */
    public function edit(Feeds $feeds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feeds  $feeds
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feeds $feeds)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feeds  $feeds
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feeds $feeds)
    {
        //
    }
}
