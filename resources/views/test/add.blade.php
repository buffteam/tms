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
<div class="container" style="margin-top: 120px;">
    <div class="row">
        <div class="col-md-6">
            <form class="form-inline">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputEmail1">文件夹名称</label>
                    <input type="text" class="form-control" name="folder_name" id="exampleInputEmail1" placeholder="文件夹名称" required>
                </div>

                <button type="submit" class="btn btn-primary">添加</button>
            </form>
        </div>

    </div>



</div>


</body>
</html>
