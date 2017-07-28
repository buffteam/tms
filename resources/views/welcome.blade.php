@extends('layouts.doc.index')
@section('style')
    <link rel="stylesheet" href="{{asset('libs/mdui/css/mdui.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <link rel="stylesheet" href="{{asset('module/doc/css/common.css')}}">

@endsection
@section('content')
    <div class="mdui-container content-top">
        <div class="mdui-row" id="container">
            <div class="mdui-col-md-2">
                <ul class="mdui-list">
                    <li class="mdui-list-item mdui-list-item-active mdui-ripple" id="desc"><a href="#descContent"><h4>使用说明</h4></a></li>
                    <li class="mdui-list-item mdui-ripple" id="updateLog"><a href="#logsContent"><h4>更新日志</h4></a></li>
                    <li class="mdui-list-item mdui-ripple" id="other"><a href="#versionContent"><h4>版本计划</h4></a></li>
                </ul>


            </div>
            <div class="mdui-col-md-9">


                <div id="updateContent" >
                    <div class="mdui-panel" mdui-panel id="descContent">

                            <div class="mdui-panel-item mdui-panel-item-open">
                                <div class="mdui-panel-item-header">
                                    <h4>使用说明</h4>
                                    <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                                </div>
                                <div class="mdui-panel-item-body">
                                    @if (count($data['desc']) > 0)
                                        @for($i = 0; $i < count($data['logs']); $i++)
                                            <div class="mdui-panel" mdui-panel>

                                                <div class="mdui-panel-item ">
                                                    <div class="mdui-panel-item-header"><h3></h3>
                                                        <div class="mdui-panel-item-header">
                                                            <div class="mdui-panel-item-title">{{$data['desc'][$i]->title}}</div>
                                                            <div class="mdui-panel-item-summary">{{$data['desc'][$i]->version}}</div>
                                                            <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                                                        </div>
                                                    </div>
                                                    <div class="mdui-panel-item-body">
                                                        <div class="markdown-body">
                                                            <?php echo $data['desc'][$i]->html_doc;?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    @else
                                        <h3>暂无使用说明</h3>
                                    @endif
                                </div>

                            </div>

                    </div>
                    <div class="mdui-panel" mdui-panel id="logsContent">
                        <div class="mdui-panel-item ">
                            <div class="mdui-panel-item-header">
                                <h4>更新日志</h4>
                                <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                            </div>
                            <div class="mdui-panel-item-body">
                                @if (count($data['logs']) > 0)
                                    @for($i = 0; $i < count($data['logs']); $i++)
                                        <div class="mdui-panel" mdui-panel>

                                            <div class="mdui-panel-item ">
                                                <div class="mdui-panel-item-header"><h3></h3>
                                                    <div class="mdui-panel-item-header">
                                                        <div class="mdui-panel-item-title">{{$data['logs'][$i]->title}}</div>
                                                        <div class="mdui-panel-item-summary">{{$data['logs'][$i]->version}}</div>
                                                        <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                                                    </div>
                                                </div>
                                                <div class="mdui-panel-item-body">
                                                    <div class="markdown-body">
                                                        <?php echo $data['logs'][$i]->html_doc;?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @else
                                    <h3>暂无使用说明</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mdui-panel" mdui-panel id="versionContent">
                        <div class="mdui-panel-item ">
                            <div class="mdui-panel-item-header">
                                <h4>版本计划</h4>
                                <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                            </div>
                            <div class="mdui-panel-item-body">
                                @if (count($data['version']) > 0)
                                    @for($i = 0; $i < count($data['version']); $i++)
                                        <div class="mdui-panel" mdui-panel>

                                            <div class="mdui-panel-item ">
                                                <div class="mdui-panel-item-header"><h3></h3>
                                                    <div class="mdui-panel-item-header">
                                                        <div class="mdui-panel-item-title">{{$data['version'][$i]->title}}</div>
                                                        <div class="mdui-panel-item-summary">{{$data['version'][$i]->version}}</div>
                                                        <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                                                    </div>
                                                </div>
                                                <div class="mdui-panel-item-body">
                                                    <div class="markdown-body">
                                                        <?php echo $data['version'][$i]->html_doc;?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @else
                                    <h3>暂无版本计划</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" value="" id="md">
    <input type="hidden" value="{{route('updateLog')}}" id="updateUrl">
    <input type="hidden" value="{{route('getDesc')}}" id="descUrl">
@endsection
@section('script')
    <script src="{{asset('/libs/editormd/editormd.min.js')}}"></script>
    <script src="{{asset('/libs/mdui/js/mdui.min.js')}}"></script>
    <script>
        var initMd = $('#md').val();
//        var  testEditor = editormd("content", {
//            width: "100%",
//            height: 1200,
//            path : "/libs/editormd/lib/",
//            readOnly: true,
//            markdown : initMd,
//            taskList : true,
////            saveHTMLToTextarea : true,
////            toolbar  : true,
//            onload : function() {
//                testEditor.previewing();
//                console.log('onload', this);
//            }
//        });

        var $container = $('#container'),
            updateUrl = $('#updateUrl').val();


        $container.on('click','#updateLog',function () {
            $('#updateContent').show();
            $('#content').hide();
//            $.get(updateUrl,function (res) {
//                $('#content').html(res.content);
//            })
        });
        $container.on('click','#desc',function () {
            $('#content').html(initMd);
        });
        $('#desc').trigger('click');
        $container.on('click','.mdui-list-item',function () {
            $(this).addClass('mdui-list-item-active').siblings().removeClass('mdui-list-item-active');
        });
    </script>
@endsection
