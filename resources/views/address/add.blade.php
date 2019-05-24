@extends('layout')
@section('title','添加收货地址')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>收货地址</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/index/images/head.jpg" />
    </div><!--head-top/-->
    <form action="login.html" method="get" class="reg-login">
        <div class="lrBox">
            <div class="lrList"><input type="text" id="name" placeholder="收货人" /></div>
            <div class="lrList"><input type="text" id="detail" placeholder="详细地址" /></div>
            <div class="lrList">
                <select id="product">
                    <option value="" selected>請選擇</option>
                    @foreach($info as $v)
                    <option value="{{$v->id}}">{{$v->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="lrList">
                <select id="city">
                    <option >区县</option>
                </select>
            </div>
            <div class="lrList">
                <select id="area">
                    <option>详细地址</option>
                </select>
            </div>
            <div class="lrList"><input type="text" id="tel" placeholder="手机" /></div>
            <input type="checkbox" id="is_default">设为默认收货地址
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="button" id="but" value="保存" />
        </div>
    </form><!--reg-login/-->

    <div class="height1"></div>
@include('public/footer')
@endsection
<script src="{{asset('/css/jquery-3.3.1.min.js')}}"></script>
<script>
    $(function () {
        //点击后获取当前点击的ID下的PID
        $('#product').change(function () {
            var id = $('#product').val();
            $.ajax({
                url:'{{url("/address/addarea")}}',
                data:{id:id},
                dataType:'json',
                type:'post',
                success:function (res) {
                    var _option = "<option>--请选择--</option>";
                    for(a = 0;a <= res.length-1;a++){
                        // _option += '<option value="'+res[a].id+'">'+res[a].name+'</option>';
                        _option += "<option value='"+res[a].id+"'>"+res[a].name+"</option>"
                    }
                    $('#city').html(_option);
                }
            })
        });
        $('#city').change(function () {
            var id = $('#city').val();
            $.ajax({
                url:'{{url("/address/addarea")}}',
                data:{id:id},
                dataType:'json',
                type:'post',
                success:function (res) {
                    var _option = "<option>--请选择--</option>";
                    for(a = 0;a <= res.length-1;a++){
                        // _option += '<option value="'+res[a].id+'">'+res[a].name+'</option>';
                        _option += "<option value='"+res[a].id+"'>"+res[a].name+"</option>"
                    }
                    $('#area').html(_option);
                }
            })
        });
        //点击保存
        $('#but').click(function () {
            var address_name = $('#name').val();
            var address_detail = $('#detail').val();
            var province = $('#product').val();
            var city = $('#city').val();
            var area = $('#area').val();
            var address_tel = $('#tel').val();
            var is_default = $('#is_default').prop('checked');
            if (is_default == true){
                is_default = 2
            } else{
                is_default = 1
            }
            $.ajax({
                url:'{{url('/address/addHandle')}}',
                data:{address_name:address_name,address_detail:address_detail,province:province,city:city,area:area,address_tel:address_tel,is_default:is_default},
                dataType:'json',
                type:'post',
                success:function (res) {
                    if (res.code == 1){
                        alert(res.msg);
                        location.href="{{url('/car/index')}}";
                    } else{
                        alert(res.msg);
                    }
                }
            })
        })
    })
</script>
