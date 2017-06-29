<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="{{asset('/libs/pure/base-min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/pure-tip.css')}}">
</head>
<body>
<h2>sadsdsdasda</h2>

<div class="pure-shade pure-alert" id="bbkAlert">
    <div class="pure-alert-container">
        <div class="pure-close"></div>
        <div class="pure-alert-title">
            温馨提示
        </div>
        <div class="pure-alert-body">
            提示内容
        </div>
    </div>
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
