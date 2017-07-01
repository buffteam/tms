<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="{{asset('/libs/bootstrap/css/bootstrap.min.css')}}">
    {{--<link rel="stylesheet" href="{{asset('/css/pure-tip.css')}}">--}}
</head>
<body>


<div class="container" style="margin-top: 120px;">

    <form action="/upload" method="post" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="file" class="form-control">
        <button class="btn btn-primary" type="submit">上传</button>
    </form>
</div>





<script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/libs/template/template-native.js')}}"></script>
<script>
    $(function () {
        var bbkAlert = $('#bbkAlert');
        bbkAlert.on('click','.pure-close',function(){
            bbkAlert.hide();
        });
    })


</script>
</body>
</html>
