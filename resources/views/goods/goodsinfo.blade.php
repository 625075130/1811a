@extends('layout')
@section('title', '产品介绍（详情）')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>产品详情</h1>
        </div>
    </header>
    <div id="sliderA" class="slider">
        <img src="{{config('app.image')}}{{$goodsinfo->goods_img}}" width="100"/>
    </div><!--sliderA/-->
    <table class="jia-len">
        <tr id="goods_id" goods_id="{{$goodsinfo->goods_id}}">
            <td>
                <strong>{{$goodsinfo->goods_name}}</strong>
            </td>
            <td align="right">
                <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
            </td>
        </tr>
        <tr>
            <td>
                <strong id="goods_number" goods_num="{{$goodsinfo->goods_number}}">剩余库存</strong>
            </td>
            <td align="right">
                {{$goodsinfo->goods_number}}
            </td>
        </tr>
    </table>
    <div class="height2"></div>
    <div class="proinfoList">
    <table class="jrgwc">
        <tr>
            <td>
                <input type="button" id="less" value="-">
                <input type="text" value="1" id="buy_num" >
                <input type="button" id="add" value="+">
                <a href="javascript:;" id="addcar">加入购物车</a>
            </td>
        </tr>
    </table>
    </div>
    <div id="ajax">
    @if($talkinfo)
        <h3 id="pinglun">评论显示区</h3>
        @foreach($talkinfo as $v)
    <table class="pinglun list" >
        <p>{{$v->u_email}}</p><p>{{$v->level}}</p><p>{{$v->desc}}</p><p>{{$v->created_at}}</p>
    </table>
    </br>
        @endforeach
        {{ $talkinfo->links() }}
     @endif
    </div>
    <table border="1px" class="tianjiapinglun" id="goods_id" goods_id="{{$goodsinfo->goods_id}}">
        <h3>评论添加区</h3>
        <tr>
            <td>用户名</td>
            <td><input type="text" readonly value="匿名用户"></td>
        </tr>
        <tr>
            <td>E_mail</td>
            <td><input type="text" id="email"></td>
        </tr>
        <tr>
            <td>评论等级</td>
            <td>
                <input type="radio" class="level" name="level" value="1星">一级
                <input type="radio" class="level" name="level" value="2星">二级
                <input type="radio" class="level" name="level" value="3星">三级
            </td>
        </tr>
        <tr>
            <td>评论内容</td>
            <td><textarea id="desc" cols="30" rows="5"></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><input type="button" id="but" value="提交评论"></td>
        </tr>
    </table>
@endsection
<script src="{{asset('/css/jquery-3.3.1.min.js')}}"></script>
<script>
    $(function () {
        //点击加号
        $('#add').click(function () {
            var _this = $(this);
            var buy_num = parseInt(_this.prev('input').val());
            var goods_num = $('#goods_number').attr('goods_num');
            var goods_id = $('#goods_id').attr('goods_id');
            if(buy_num >= goods_num){
                alert('购买数量不能超过库存');
                _this.prop('disabled',true);
            }else if(buy_num < 1){
                _this.prev('input').val(1);
            }else{
                _this.prev('input').val(buy_num+1);
            }
        })
        $('#addcar').click(function () {
            var goods_id = $('#goods_id').attr('goods_id');
            var buy_num = parseInt($('#buy_num').val());
            $.ajax({
                url:"{{url('/car/addcar')}}",
                data:{goods_id:goods_id,buy_num:buy_num},
                dataType:'json',
                type:'post',
                success:function (res) {
                    if(res.code == 1){
                        alert(res.msg);
                        window.location.href = "{{url('/car/index')}}";
                    }else if (res.code == 0) {
                        alert(res.msg);
                        window.location.href = "{{url('/login/login')}}";
                    }else{
                        alert(res.msg);
                    }
                }
            })
        })
        //点击评论
        $('#but').click(function () {
            var u_email = $('#email').val();
            var level = $('.level:checked').val();
            var desc = $('#desc').val();
            var goods_id = $('#goods_id').attr('goods_id');
            $.ajax({
                url:'/goods/talkAdd',
                data:{u_email:u_email,level:level,desc:desc,goods_id:goods_id},
                dataType:'json',
                type:'post',
                success:function (res) {
                    if(res.code == 1){
                        alert(res.msg);
                        var _html = "<table><p>"+res.info.u_email+"</p><p>"+res.info.level+"</p><p>"+res.info.desc+"</p><p>"+res.info.created_at+"</p></table></br>"
                        // console.log(_html)
                        $('#pinglun').after(_html);
                    }else{
                        alert(res.msg);
                    }
                }
            })
        })
        $(document).on('click','.page-item a',function(){
            var url = $(this).prop('href');
            $.ajax({
                url:url,
                data:'',
                dataType:'json',
                type:'get',
                success:function (res) {
                    $('#ajax').html(res)
                }
            })
        })
    })
</script>
