@extends('layouts.md')
@section('style')
    <style>
        .avatar-list img {
            /*width: 100%;*/
            height: 150px;
        }
    </style>
    @endsection
@section('content')
<div class="mdui-container" style="margin-top: 80px;" >

        <div class="mdui-panel" mdui-panel>


            <div class="mdui-panel-item mdui-panel-item-open">
                <div class="mdui-panel-item-header">上传头像</div>
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

            <div class="mdui-panel-item">
                <div class="mdui-panel-item-header">头像管理</div>
                <div class="mdui-panel-item-body">
                    <div class="mdui-row avatar-list">
                        @foreach($list as $items)
                            <div class="mdui-col-md-3 mdui-card">
                                <div class="mdui-card-media">
                                    <img src="{{asset($items->url)}}"/>
                                    <div class="mdui-card-actions">
                                        <button class="mdui-btn mdui-ripple mdui-ripple-white">
                                            <label class="mdui-checkbox">
                                                <input type="checkbox"/>
                                                <i class="mdui-checkbox-icon"></i>
                                            </label>
                                        </button>
                                        <button class="mdui-btn mdui-ripple mdui-color-blue mdui-ripple-white">选取为头像</button>
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
    <script src="{{ asset('libs/mdui/js/mdui.min.js') }}"></script>
    <script src="{{asset('module/doc/js/dropzone.js')}}"></script>
    <script>
//        var dropz = new Dropzone("#dropz", {
//            url: "handle-upload.php",
//            maxFiles: 10,
//            maxFilesize: 512,
//            acceptedFiles: ".js,.obj,.dae"
//        });
    </script>
    @endsection


