@extends('layouts.admin')
@section('content')
    <div class="mdui-bread-crumb ">
        面包屑

    </div>
    <div class="mdui-divider" style="margin-bottom: 15px;"></div>

    <div class="mdui-row count-row">
        <div class="mdui-col-xs-4">
            <div class="count-box-small">
                <p id="userTotal" class="count-box-num">0</p>
                <p>用户量</p>
            </div>
        </div>
        <div class="mdui-col-xs-4">
            <div class="count-box-small">
                <p id="notesTotal" class="count-box-num">0</p>
                <p>笔记数量</p>
            </div>
        </div>
        <div class="mdui-col-xs-4">
            <div class="count-box-small">
                <p id="recycleCount" class="count-box-num">0</p>
                <p>回收站数量</p>
            </div>
        </div>
    </div>
    <div class="mdui-row count-row">
        <div class="mdui-col-xs-6">
            <div class="count-box">
                <div id="noteDistribution" style="width: 100%;height:400px;"></div>
            </div>
        </div>
        <div class="mdui-col-xs-6">
            <div class="count-box">
                <div id="noteTopList" style="width: 100%;height:400px;"></div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="{{asset('/libs/jquery/2.2.3/jquery.min.js')}}"></script>
    <script src="{{asset('/libs/jquery-animateNumber/jquery.animateNumber.min.js')}}"></script>
    <script src="{{asset('/libs/eChart/echarts.common.min.js')}}"></script>
    <script src="{{asset('/module/admin/js/dashboard.js')}}"></script>
@endsection