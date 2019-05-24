
@section('title','12321')
@extends('layout')
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <form action="#" method="get" class="prosearch"><input type="text" /></form>
        </div>
    </header>
    <ul class="pro-select">
        <li class="pro-selCur"><a href="javascript:;">新品</a></li>
        <li><a href="javascript:;">销量</a></li>
        <li><a href="javascript:;">价格</a></li>
    </ul><!--pro-select/-->
    <div class="prolist">
        @if($goodsinfo == null)
            <h5>该分类下没有商品</h5>
        @else
        @foreach($goodsinfo as $v)
        <dl>
            <dt><a href="/goods/goodsinfo/goods_id/{{$v->goods_id}}"><img src="{{config('app.image')}}{{$v->goods_img}}" width="100" height="100" /></a></dt>
            <dd>
                <h3><a href="{{url('/goods/goodsinfo?goods_id=')}}{{$v->goods_id}}">{{$v->goods_name}}</a></h3>
                <div class="prolist-price"><strong>¥{{$v->shop_price}}</strong></div>
                <div class="prolist-yishou"> <em>库存：{{$v->goods_number}}</em></div>
            </dd>
            <div class="clearfix"></div>
        </dl>
        @endforeach
        @endif
    </div><!--prolist/-->
    <div class="height1"></div>
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/style.js"></script>
<!--焦点轮换-->
<script src="js/jquery.excoloSlider.js"></script>
<script>
    $(function () {
        $("#sliderA").excoloSlider();
    });
</script>
</body>
</html>