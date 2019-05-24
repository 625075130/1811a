@extends('layout')
@section('title', '吴炳坤123')
@section('content')
<div class="head-top">
    <img src="/index/images/head.jpg" />
    <dl>
        <dt><a href="user.html"><img src="/index/images/touxiang.jpg" /></a></dt>
        <dd>
            <h1 class="username">三级分销终身荣誉会员</h1>
            <ul>
                <li><a href="prolist.html"><strong>34</strong><p>全部商品</p></a></li>
                <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
                <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
                <div class="clearfix"></div>
            </ul>
        </dd>
        <div class="clearfix"></div>
    </dl>
</div><!--head-top/-->
<form action="#" method="get" class="search">
    <input type="text" class="seaText fl" />
    <input type="submit" value="搜索" class="seaSub fr" />
</form><!--search/-->
@if($u_id == '')
<ul class="reg-login-click">
    <li><a href="{{url('/login/login')}}">登录</a></li>
    <li><a href="{{url('/login/register')}}" class="rlbg">注册</a></li>
    <div class="clearfix"></div>
</ul><!--reg-login-click/-->
@else
    <ul class="reg-login-click">
        <li>欢迎{{$u_email}}登陆</li>
        <li><a href="{{url('/login/loginout')}}" class="rlbg">退出</a></li>
        <div class="clearfix"></div>
    </ul><!--reg-login-click/-->
@endif
<div id="sliderA" class="slider">
    <img src="/index/images/image1.jpg" />
    <img src="/index/images/image2.jpg" />
    <img src="/index/images/image3.jpg" />
    <img src="/index/images/image4.jpg" />
    <img src="/index/images/image5.jpg" />
</div><!--sliderA/-->
<ul class="pronav">
    @foreach($brandinfo as $v)
    <li><a href="{{url('/goods/index?brand_id=')}}{{$v->brand_id}}">{{$v->brand_name}}</a></li>
    @endforeach
    <div class="clearfix"></div>
</ul><!--pronav/-->
<div class="index-pro1">
{{--    商品展示--}}
    @foreach($goodsinfo as $v)
    <div class="index-pro1-list">
        <dl>
            <dt><a href="{{url('/goods/goodsinfo?goods_id=')}}{{$v->goods_id}}"><img src="{{config('app.image')}}{{$v->goods_img}}" /></a></dt>
            <dd class="ip-text"><a href="{{url('/goods/goodsinfo?goods_id=')}}{{$v->goods_id}}">{{$v->goods_name}}</a><span>库存：{{$v->goods_number}}</span></dd>
            <dd class="ip-price"><strong>¥{{$v->shop_price}}</strong>
        </dl>
    </div>
    @endforeach
    <div class="clearfix"></div>
</div><!--index-pro1/-->
<div class="prolist">
    <dl>
        <dt><a href="proinfo.html"><img src="/index/images/prolist1.jpg" width="100" height="100" /></a></dt>
        <dd>
            <h3><a href="proinfo.html">四叶草</a></h3>
            <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
            <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
        </dd>
        <div class="clearfix"></div>
    </dl>
    <dl>
        <dt><a href="proinfo.html"><img src="/index/images/prolist1.jpg" width="100" height="100" /></a></dt>
        <dd>
            <h3><a href="proinfo.html">四叶草</a></h3>
            <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
            <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
        </dd>
        <div class="clearfix"></div>
    </dl>
    <dl>
        <dt><a href="proinfo.html"><img src="/index/images/prolist1.jpg" width="100" height="100" /></a></dt>
        <dd>
            <h3><a href="proinfo.html">四叶草</a></h3>
            <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
            <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
        </dd>
        <div class="clearfix"></div>
    </dl>
</div><!--prolist/-->
<div class="joins"><a href="fenxiao.html"><img src="/index/images/jrwm.jpg" /></a></div>
<div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>

<div class="height1"></div>

@include('public/footer')
@endsection