@extends('layout')
@section('title','快来加入我们的金窝吧')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>会员注册</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/index/images/head.jpg" />
    </div><!--head-top/-->
    <form action="user.html" method="get" class="reg-login">
        <h3>还没有三级分销账号？点此<a class="orange" href="{{url('/login/register')}}">注册</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text" id="email" placeholder="输入手机号码或者邮箱号" /></div>
            <div class="lrList"><input type="text" id="pwd" placeholder="输入密码" /></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="button" id="but" value="立即登录" />
        </div>
    </form><!--reg-login/-->
    <div class="height1"></div>
    @include('public/footer')
@endsection
<script src="{{asset('/css/jquery-3.3.1.min.js')}}"></script>
<script>
    $(function(){
        $('#but').click(function () {
            var email = $('#email').val();
            var pwd = $('#pwd').val();
            var reg = /^[0-9]{3}@163|@qq(\.)com|con$/;
            var rega = /^[1][3,5,7,8]\d{9}$/;
            if(email == ''){
                alert('请填入手机号或邮箱码');return;
            }
            if(pwd == ''){
                alert('请输入密码');return;
            }
            if(!reg.test(email) || !reg.test(email)){
                alert('请输入正确的手机号或邮箱');return;
            }
            $.ajax({
                url:"{{url('/login/login_do')}}",
                type:'post',
                dataType:'json',
                data:{email:email,pwd:pwd},
                success:function (res) {
                    if(res.code == 1){
                        alert(res.msg)
                        window.location.href = "{{url('/')}}";
                    }else{
                        alert(res.msg)
                    }
                }
            })
        })
    })
</script>