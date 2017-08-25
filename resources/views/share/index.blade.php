@extends('layouts.share')

@section('style')
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <link rel="stylesheet" href="{{asset('module/share/css/index.css')}}">
@endsection

@section('content')
    <div class="note-wrap">
        @if (isset($list))
            <div class="note-title">{{$list['title']}}</div>
            <div class="note-content">
                {!! $list['content'] !!}
            </div>
        @else

        @endif
    </div>
@endsection
