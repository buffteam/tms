@extends('layouts.admin')
@section('content')
    <div class="mdui-bread-crumb ">
        账号审核

    </div>
    <div class="mdui-divider" style="margin-bottom: 15px;"></div>
    <div class="mdui-table-fluid">
        <table class="mdui-table mdui-table-hoverable mdui-table-selectable" id="table">
            <thead>
            <tr>
                <th>序号</th>
                <th>昵称</th>
                <th>权限</th>
                <th>邮箱</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($list as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->auth }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td ><button type="button" class="mdui-btn mdui-btn-raised mdui-color-theme-accent verify" data-id="{{$item->id}}" >审核</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <input type="hidden" value="{{url('account/verify')}}" id="verifyUrl">
@endsection
@section('script')
    <script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/libs/layer-v3.0.3/layer.js')}}"></script>
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var $table = $('#table');
            $table.on('click','.verify',function () {
                var $this = $(this),
                    id = $this.data('id'),
                    pTarget = $this.parent().parent();
                $.post($('#verifyUrl').val(),{id:id},function (res) {
                    if (res.code == 200) {
                        layer.msg(res.msg,{time:2000,success:function () {
                            pTarget.remove();
                        }});

                    } else {
                        layer.msg(res.msg,{time:2000});
                    }
                })
            })
        })
    </script>
@endsection