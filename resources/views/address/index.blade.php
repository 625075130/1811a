@extends('layout')
@section('title','收货地址')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>收货地址</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="images/head.jpg" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><a href="address.html" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
            <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">删除信息</a></td>
        </tr>
    </table>

    <div class="dingdanlist" >
        @foreach($addressinfo as $v)
        <table>

            <tr>
                <td width="50%">
                    <h3>{{$v->address_name}}</h3>
                    <time>{{$v->address_detail}}</time>
                </td>
                <td align="right"><a href="address.html" class="hui"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
            </tr>
        </table>
        @endforeach
    </div><!--dingdanlist/-->

    <div class="height1"></div>
    @include('public/footer')
@endsection