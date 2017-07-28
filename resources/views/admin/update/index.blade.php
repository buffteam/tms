@extends('layouts.admin')
@section('style')
    <style>
        .module-section {
            margin: 15px 0;
            padding: 15px;
            border: 1px dotted gainsboro;
        }
    </style>
@endsection
@section('content')
    <div class="mdui-bread-crumb ">
        面包屑

    </div>
    <div class="mdui-divider" style="margin-bottom: 15px;"></div>
    <div class="module-section" >
        <a href="{{url('updateLog/create')}}" class="mdui-btn mdui-color-theme-accent  mdui-color-blue mdui-ripple">添加记录</a>
    </div>
    <div class="mdui-table-fluid">
        <table class="mdui-table mdui-table-hoverable ">
            <thead>
            <tr>
                <th>序号</th>
                <th>主题</th>
                <th>类型</th>
                <th>版本号</th>
                <th>更新内容</th>
                <th>创建时间</th>
            </tr>
            </thead>
            <tbody>
             @foreach($list as $item)
                 <form id="form{{$item->id}}" action="{{ url('updateLog/show') }}" method="POST"
                       style="display: none;">
                     <input type="hidden" name="id" value="{{$item->id}}">
                     {{ csrf_field() }}
                 </form>
                 <tr  onclick="document.getElementById('form{{$item->id}}').submit();">
                     <td>{{$item->id}}</td>
                     <td>{{$item->title}}</td>
                     <td>{{$item->type}}</td>
                     <td>{{$item->version}}</td>
                     <td>{{substr($item->html_doc,0,20)}}</td>
                     <td>{{$item->created_at}}</td>
                 </tr>

             @endforeach

            </tbody>
        </table>
    </div>
    <script>
        function goDetail(id) {
            window.location.href = '/updatelog/show?id='+id;
        }
    </script>
@endsection