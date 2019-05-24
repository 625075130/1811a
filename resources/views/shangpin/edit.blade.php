<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>文章修改</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

 /*           .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
*/
            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: left;
                padding:25px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
            <b>商品修改</b></br>

            @if ($errors->any())     
            <div class="alert alert-danger">         
            <ul>             
            @foreach ($errors->all() as $error)                 
            <li>{{ $error }}</li>            
            @endforeach         
            </ul>     
            </div> 
            @endif 
            <form action="{{url('/shangpin/update/'.$data->shang_id)}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <p><b>商品名称：</b><input type="text" name="shang_name" value="{{$data->shang_name}}"></p>
                <p><b>商品数量：</b><input type="text" name="shang_num" value="{{$data->shang_num}}"></p>
                <p><b>商品描述：</b><textarea type="text" name="shang_desc" >{{$data->shang_desc}}</textarea></p>
                <p><b>商品图片：</b><img src="{{config('app.img_url')}}{{$data->shang_logo}}" width="200"><input type="file" name="shang_logo"></p>
                <!-- <p><input type="button" value="提交" id="btn"></p> -->
                <p><button>提交</button></p>
            </form>
            </div>
        </div>
    </body>
</html>
<script scr="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript">

</script>
