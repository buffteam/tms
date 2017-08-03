@extends('layouts.md')
@section('style')
    <style>
        .avatar-list img {
            height: 150px;
        }
    </style>
    @endsection
@section('content')
<div class="mdui-container" style="margin-top: 80px;" >

        <div class="mdui-panel" mdui-panel>
            <div class="mdui-panel-item mdui-panel-item-open">
                <div class="mdui-panel-item-header">
                    <div class="mdui-panel-item-title">上传头像</div>
                    <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                </div>
                <div class="mdui-panel-item-body">
                    @if (isset($status))
                        <div class="mdui-alert mdui-alert-success">
                             <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white mdui-close"><i
                                         class="mdui-icon material-icons"
                                         data-dismiss="alert">&#xe14c;</i></span>
                            {{ $status }}
                        </div>
                    @endif
                    @if(count($errors))
                        <div class="mdui-alert  mdui-alert-danger">
                                    <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white mdui-close"><i
                                                class="mdui-icon material-icons"
                                                data-dismiss="alert">&#xe14c;</i></span>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                    <form action="" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="mdui-textfield">
                            <label class="mdui-textfield-label">选择图像</label>
                            <input class="mdui-textfield-input" type="file" name="avatar"/>
                        </div>
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <button type="submit"
                                    class="mdui-btn mdui-btn-raised mdui-btn-dense mdui-color-blue mdui-ripple ">
                                上传
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mdui-panel-item mdui-panel-item-open" id="avatarManage">
                <div class="mdui-panel-item-header ">
                    <div class="mdui-panel-item-title">头像管理</div>
                     <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                </div>
                <div class="mdui-panel-item-body mdui-color-theme-50" >
                    <div class="current-avatar">
                        <h3>当前头像</h3>
                        @if (!empty(Auth::user()->avatar))
                            <img src="{{Auth::user()->avatar}}" class="" id="currentAvatar" alt="" style="width: 140px;height: 120px;">
                        @endif
                    </div><br/>
                    <h3>图片列表</h3>
                    <div class="mdui-row-xs-3 mdui-row-sm-4 mdui-row-md-5 mdui-row-lg-6 mdui-row-xl-7 mdui-grid-list avatar-list">
                        @foreach($list as $items)
                                <div class="mdui-col" data-id="{{$items->id}}">
                                    <div class="mdui-grid-tile" >
                                        <a href="javascript:;">  <img src="{{asset($items->url)}}"/></a>
                                        <div class="mdui-grid-tile-actions"  data-url="{{$items->url}}" data-id="{{$items->id}}" data-active="{{$items->active}}">
                                            {{--@if ($items->active != 1 )--}}
                                            @if ($items->u_id != 0)

                                            <button class="mdui-fab mdui-fab-mini mdui-color-red mdui-ripple del" title="删除图片"><i class="mdui-icon material-icons">delete_forever</i></button>
                                            @endif
                                            <button class="mdui-fab mdui-fab-mini mdui-color-blue mdui-ripple setting" title="设置头像"><i class="mdui-icon material-icons">account_box</i></button>

                                            {{--@else--}}
                                                {{--<h3 >当前头像</h3>--}}
                                            {{--@endif--}}



                                        </div>
                                    </div>
                                </div>
                        @endforeach


                    </div>
                </div>
            </div>

        </div>
</div>
@endsection

@section('script')
    <script src="{{asset('/libs/layer-v3.0.3/layer.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var $avatarManage = $('#avatarManage'),
            $currentAvatar = $('#currentAvatar');
        // 设置头像
        $avatarManage.on('click','.setting',function () {
            var $p = $(this).parent(),
                url = $p.data('url'),
                id = $p.data('id');
            $.post('./avatar/select',{url:url,id:id},function (res) {
                if (res.code == 200) {
                    layer.msg(res.msg,{time:2000});
                    $currentAvatar.attr('src',url);
                } else {
                    layer.msg(res.msg,{time:2000});
                }
            });

        });

        // 删除头像
        $avatarManage.on('click','.del',function () {
            var $this = $(this),
                $p = $this.parent(),
                id = $p.data('id'),
                url = $p.data('url');
            $.post('./avatar/del',{id:id,url:url},function (res) {
                if (res.code == 200) {
                    layer.msg(res.msg,{
                        time:2000,
                        success:function () {
                            $('.avatar-list').find('.mdui-col[data-id='+id+']').remove();
                        }
                    });

                } else {
                    layer.msg(res.msg,{time:2000});
                }
            });

        });
    </script>
@endsection
