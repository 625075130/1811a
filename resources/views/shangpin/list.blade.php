<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>商品列表</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/page.css')}}" rel="stylesheet">
        <script type="text/javascript" src="/admin/js/jquery-3.3.1.js"></script>

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

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
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
        <meta name="csrf-token" content="{{csrf_token()}}">
    </head>
    <body>
        <div class="flex-center position-ref full-height">


            <div class="content">
                <h3>商品列表</h3>
             <form action="">
                <input type="text" name="shang_name" placeholder="请输入商品名称搜索" >
                <button>搜索</button>
             </form>
                <table border="1">
                <tr>
                    <td>编号</td>
                    <td>商品名称</td>
                    <td>商品数量</td>
                    <td>商品图片</td>
                    <td>商品描述</td>
                    <td>添加日期</td>
                    <td>操作</td>
                </tr>
                @if($data)
                @foreach($data as $v)
                <tr id="tr2">
                    <td>{{$v->shang_id}}</td>
                    <td>{{$v->shang_name}}</td>
                    <td>{{$v->shang_num}}</td>
                    <td><img src="{{config('app.img_url')}}{{$v->shang_logo}}" width="200" ></td>
                    <td>{{$v->shang_desc}}</td>
                    <td>{{$v->create_time}}</td>
                    <td>[<a href="javascript:void(0);" class="del" shang_id="{{$v->shang_id}}">删除</a>][<a href="/shangpin/edit/{{$v->shang_id}}">修改</a>][<a href="/shangpin/xiangqing/{{$v->shang_id}}">详情</a>]</td>
                </tr>
                @endforeach
                @endif
                </table>
            </div>
        </div>
         {{$data->appends($query)->links()}}
    </body>
</html>
<!-- <script scr="{{asset('js/jquery-3.3.1.min.js')}}"></script> -->
<script type="text/javascript">
    $('.del').click(function(){
        var shang_id=$(this).attr('shang_id');
        alert(shang_id);
        if(!shang_id){
            alert('请选择一个文章进行删除！');
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('/shangpin/del/'+shang_id,'',function(msg){
            // alert(msg.msg);
            if(msg.code=1){
                $('#tr2').remove();
            }
            window.location.reload();
        },'json');
        
    });
</script>
