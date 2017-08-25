@extends('layouts.share')

@section('style')
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <link rel="stylesheet" href="{{asset('module/share/css/index.css')}}">
@endsection

@section('content')
    <div class="note-wrap">
        @if ($data)

        @else()
        <div class="note-title">{{}}</div>
        <div class="note-content"></div>
        @endif
    </div>
@endsection
