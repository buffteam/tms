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
                   <div class="" style="margin-bottom: 25px;">
                       <button class="mdui-btn mdui-btn-dense mdui-color-deep-orange mdui-ripple" id="del">删除</button>
                       {{--<button class="mdui-btn mdui-btn-raised mdui-btn-dense mdui-color-red mdui-ripple" id="empty">清空</button>--}}
                   </div>
                    <div class="mdui-row-xs-3 mdui-row-sm-4 mdui-row-md-5 mdui-row-lg-6 mdui-row-xl-7 mdui-grid-list avatar-list">
                        @foreach($list as $items)
                                <div class="mdui-col" data-id="{{$items->id}}">
                                    <div class="mdui-grid-tile" >
                                        <a href="javascript:;">  <img src="{{asset($items->url)}}"/></a>
                                        <div class="mdui-grid-tile-actions" style="display:flex;justify-content: center;align-items: center;">
                                            @if ($items->u_id != 0)
                                            <label class="mdui-checkbox check" data-id="{{$items->id}}" data-url="{{$items->url}}" >
                                                <input type="checkbox"/>
                                                <i class="mdui-checkbox-icon"></i>
                                            </label>
                                            @endif
                                            @if($items->active == 1)
                                                    <div class="mdui-grid-tile-title">当前头像</div>
                                                @else
                                                    <button class="mdui-btn  mdui-color-purple mdui-ripple setting" data-url="{{$items->url}}">
                                                        设置为头像
                                                    </button>
                                                @endif

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
        var avatarManage = $('#avatarManage'),
            urlList = [],
            idList = [];
        // 设置头像
        avatarManage.on('click','.setting',function () {
            var url = $(this).data('url');
            $.post('./avatar/select',{url:url},function (res) {
                if (res.code == 200) {
                    layer.msg(res.msg,{time:2000});
                } else {
                    layer.msg(res.msg,{time:2000});
                }
            });

        });
        // 选择图片删除
        avatarManage.on('click','.check',function (e) {

            if (e.target.nodeName != "I" && e.target.nodeName != "LABEL") {
                var $this = $(this),
                    url = $this.data('url'),
                    id = $this.data('id'),
                    urlIndex = $.inArray(url,urlList),
                    idIndex = $.inArray(id,idList);
                var checked = $this.find(':checkbox').prop('checked');

                if (checked) {
                    urlList.push(url);
                    idList.push(id);
                } else {
                    urlList.splice(urlIndex,1);
                    idList.splice(idIndex,1);
                }
            }
        });

        // 删除头像
        avatarManage.on('click','#del',function () {
            var url = $(this).data('url');
            $.post('./avatar/del',{idList:idList,urlList:urlList},function (res) {
                if (res.code == 200) {
                    layer.msg(res.msg,{time:2000,success:function () {
                        delTargetElement(idList);
                    }});

                } else {
                    layer.msg(res.msg,{time:2000});
                }
            });

        });
        function delTargetElement(arr) {
            var i = 0,
                l = arr.length;
            avatarManage.find('.mdui-col').each(function () {
                var $this = $(this),
                    id = $this.data('id');
                for (; i < l; i++) {
                    if (id == arr[i]) {
                        $this.remove();
                        break;
                    }
                }
            })

        }

        // 清空
//        avatarManage.on('click','#empty',function () {
//            var url = $(this).data('url');
//            $.post('./avatar/del',{url:url},function (res) {
//                if (res.code == 200) {
//                    layer.msg(res.msg,{time:2000});
//                    delTargetElement(idList);
//                } else {
//                    layer.msg(res.msg,{time:2000});
//                }
//            });
//
//        })
    </script>
@endsection
