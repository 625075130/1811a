@extends('layout')
@section('title', '欢迎加入黄金窝(注册)')
@section('content')
    <style>
        .a1{
            background: orange;
            align-content: center;
            width: 70px;
        }
    </style>
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>会员注册</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/index/images/head.jpg" />
    </div><!--head-top/-->
    <form action="login.html" method="get" class="reg-login">
        <h3>已经有账号了？点此<a class="orange" href="{{url('/login/login')}}">登陆</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text" id="email" placeholder="输入手机号码或者邮箱号" /></div>
            <div class="lrList2"><input type="text" id="code" placeholder="输入短信验证码" width="10"/></div>
            <p class="a1" ><input type="button" id="send" value="获取验证码"></p>
            <div class="lrList"><input type="text" id="pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
            <div class="lrList"><input type="text" id="repwd" placeholder="再次输入密码" /></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="button" id="sub" value="立即注册" />
        </div>
    </form><!--reg-login/-->
    <div class="height1"></div>
    @include('public/footer')
@endsection
<script src="{{asset('/css/jquery-3.3.1.min.js')}}"></script>
<script>
    $(function(){
        //失焦事件（验证唯一）
        $('#email').blur(function(){
            var email = $('#email').val();
            var flag = true;
            $.ajax({
                url:"/login/checkname",
                data:{email:email},
                dataType:'json',
                async:false,
                type:'post',
                success:function(res){
                    if(res.count >0){
                        flag = false;
                        alert('用户名已存在');
                    }
                }
            })
            if(flag == false){
                return;
            }
        })
        //点击事件（发送邮件）
        $('#send').click(function(){
            var email = $('#email').val();
            var reg = /^1\d{10}$/;
            var rega = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;

            // var rega = /^[0-9]{3}@163|@qq(\.)com|con$/;
            if(email == ''){
                alert('邮箱必填');return;
            }
            if(reg.test(email) || rega.test(email)){
                $.ajax({
                    url:"/login/sendemail",
                    data:{email:email},
                    dataType:'json',
                    type:'post',
                    success:function(res){
                        console.log(res);
                    }
                })
                return;
            }else{
                alert('请输入正确的邮箱或手机号');
                return;
            }
        })
        //点击事件 验证验证码，入库
        $('#sub').click(function(){
            var flag = true;
            var email = $('#email').val();
            var pwd = $('#pwd').val();
            var repwd = $('#repwd').val();
            var code = $('#code').val();
            if(pwd == '' || repwd == ''){
                alert('密码和确认密码都要填写');
                return;
            }
            if(pwd != repwd){
                alert('密码和确认密码不一致');
                return;
            }
            $.ajax({
                url:"/login/checkcode",
                data:{code:code,email:email},
                dataType:'json',
                async:false,
                type:'post',
                success:function(res){
                    if(res.code == 0){
                        alert('验证码有误')
                        flag = false;
                    }
                }
            })
            if(flag == false){
                return ;
            }
            $.ajax({
                url:"/login/register_do",
                data:{u_code:code,u_email:email,u_pwd:pwd,repwd:repwd},
                dataType:'json',
                async:false,
                type:'post',
                success:function(res){
                 if (res.code == 1){
                     alert(res.msg);
                     window.location.href = "/login/login";
                 }else{
                     alert(res.msg);
                 }
                }
            })
        })
    })
</script>
