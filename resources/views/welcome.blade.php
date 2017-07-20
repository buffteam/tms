@extends('layouts.doc.index')
@section('style')
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <link rel="stylesheet" href="{{asset('module/doc/css/common.css')}}">
@endsection
@section('content')
    <div class="container content-top">
        <div id="test-editormd" class="editormd-onlyread"></div>
    </div>
@endsection
@section('script')
    <script src="{{asset('/libs/editormd/editormd.min.js')}}"></script>
    <script>

        $.get("@php echo route('getReadme'); @endphp", function(md){
            testEditor = editormd("test-editormd", {
                width: "100%",
                height: 900,
                path : "./libs/editormd/lib/",
                readOnly: true,
                markdown : md,
                taskList : true,

                onload : function() {
                    testEditor.previewing();
                    console.log('onload', this);
                }
            });
        });

    </script>
@endsection
