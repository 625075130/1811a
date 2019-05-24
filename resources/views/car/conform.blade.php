<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="/index/images/favicon.ico" />

    <!-- Bootstrap -->
    <link href="/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/index/css/style.css" rel="stylesheet">
    <link href="/index/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond./index/js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>购物车</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/index/images/head.jpg" />
    </div><!--head-top/-->
    <div class="dingdanlist">
        <table>
            @if($addressinfo == '')
            <tr>
                <td class="dingimg" width="75%" colspan="2" id="">新增收货地址</td>
                <td align="right"><img src="/index/images/jian-new.png" /></td>
            </tr>
            @else
                <td>请选择一个收货地址</td>
                @foreach($addressinfo as $v)
            <tr>
                <td>
                    <input type="radio" address_id="{{$v['address_id']}}" id="address_id" name="address_id" value="{{$v['address_detail']}}">{{$v['address_detail']}}
                </td>
            </tr>
                @endforeach
            @endif
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">支付方式</td>
                <td align="right"><span class="hui">支付宝</span></td>
            </tr>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr><td colspan="3" style="height:10px; background:#fff;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="3">商品清单</td>
            </tr>
            @foreach($info as $v)
                <tr goods_id="{{$v->goods_id}}" class="goods_id">
                    <td class="dingimg" width="15%"><img src="{{config('app.image')}}{{$v->goods_img}}" /></td>
                    <td width="50%">
                        <h3>{{$v->goods_name}}</h3>
                        <time>下单时间：{{$v->created_at}}</time>
                    </td>
                    <td align="right"><span class="qingdan">X {{$v->buy_num}}</span></td>
                </tr>
                <tr>
                    <th colspan="3"><strong class="orange">¥{{$v->buy_num*$v->shop_price}}</strong></th>
                </tr>
            @endforeach
        </table>
    </div><!--dingdanlist/-->


</div><!--content/-->

<div class="height1"></div>
<div class="gwcpiao">
    <table>
        <tr>
            <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
            <td width="50%">总计：<strong class="orange">¥{{$count}}</strong></td>
            <td width="40%"><a href="javascript:;" class="jiesuan">提交订单</a></td>
        </tr>
    </table>
</div><!--gwcpiao/-->
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/index/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/index/js/bootstrap.min.js"></script>
<script src="/index/js/style.js"></script>
<!--jq加减-->
<script src="/index/js/jquery.spinner.js"></script>
<script>
    $('.spinnerExample').spinner({});
</script>
</body>
</html>
<script>
    $(function () {
        $('.jiesuan').click(function () {
            var address_id = $('#address_id:checked').attr('address_id');
            var goods_id = '';
            $('.goods_id').each(function (index) {
                goods_id += $(this).attr('goods_id')+',';
            })
            goods_id = goods_id.substr(0,goods_id.length-1);
            $.ajax({
                url:'{{url('/order/addOrder')}}',
                data:{goods_id:goods_id,address_id:address_id},
                dataType:'json',
                type:'post',
                success:function (res) {
                    if(res.code == 1){
                        alert(res.msg)
                        location.href="{{url('/order/successOrder')}}?order_id="+res.order_id;
                    }else{
                        alert(res.msg)
                    }
                }
            })
        })
    })
</script>