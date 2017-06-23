<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="{{asset('/libs/bootstrap/css/bootstrap.min.css')}}">

</head>
<body>
<div class="container">
    <button type="button"></button>
    <div class="list-group" id="list">
        <a href="#" class="list-group-item list-group-item-heading active">
            Cras justo odio
        </a>
        <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
        <a href="#" class="list-group-item">Morbi leo risus</a>
        <a href="#" class="list-group-item">Porta ac consectetur ac</a>
        <a href="#" class="list-group-item">Vestibulum at eros</a>
    </div>

</div>

<script type="template" id="tpl">

    <% for (var i = 0; i < list.length; i++) {%>
        <a href="#" class="list-group-item <%= list[i].id == 1 ? 'active' : '' %>" data-id="<%= list[i].name %>"><%= list[i].name %></a>
    <% } %>

</script>
<script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/libs/template/template-native.js')}}"></script>
<script>
    var listData = localStorage.getItem('data');
    if (listData !== null) {
        $('#list').html(template('tpl',{list:JSON.parse(listData)}));
        var timer = setTimeout(function(){
            request();
            clearTimeout(timer);
        },2000);
    } else {
        request();
    }
    function request() {
        $.ajax({
            method: 'get',
            url: '/getAll',
            dataType: 'json',
            success: function (res) {
                localStorage.setItem('data',JSON.stringify(res));
                $('#list').html(template('tpl',{list:res}));
            }
        });
    }

</script>
</body>
</html>
