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
    <table class="shoucangtab">
        <tr>
            <td width="75%"><span class="hui">购物车共有：<strong class="orange">2</strong>件商品</span></td>
            <td width="25%" align="center" style="background:#fff url(/index/images/xian.jpg) left center no-repeat;">
                <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
            </td>
        </tr>
    </table>

    <div class="dingdanlist">

        <table>
            <tr>
                <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" class="allbox" name="1" /> 全选</a></td>
            </tr>
            @foreach($carinfo as $v)
                <tr goods_id="{{$v['goods_id']}}">
                    <td width="4%" class="1"><input type="checkbox" class="box" name="1" goods_id="{{$v['goods_id']}}" /></td>
                    <td class="dingimg" width="15%"><img src="{{config('app.image')}}{{$v['goods_img']}}" /></td>
                    <td width="42%">
                        <h3>{{$v['goods_name']}}</h3>
                        <time>{{$v['created_at']}}</time>
                    </td>
                    <td>
                    <td align="right" class="11">
                        <input type="hidden" name="goods_num" value="{{$v['goods_number']}}">
                        <input type="text" class="spinnerExample" />
                        <input type="hidden" class="buy_number" value="{{$v['buy_num']}}">
                    </td>
                    </td>
                </tr>
                <tr>
                    <th colspan="4"><strong class="orange count">¥{{$v['shop_price']*$v['buy_num']}}</strong></th>
                </tr>
            @endforeach
        </table>

    </div><!--dingdanlist/-->

    <div class="dingdanlist">

        <tr>
            <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
            <td width="50%">总计：<strong class="orange " id="counts">¥0</strong></td>
            <td width="40%"><a href="javascript:;" class="jiesuan">去结算</a></td>
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
</body>
</html>
<script>
    $(function () {

        $('.spinnerExample').spinner({ });
//            购买数量
        var buy_number_db =  $('.buy_number');
        buy_number_db.each(function(){
            var buy_number1 =  $(this).val();
            $(this).prev().children().eq(1).val(buy_number1);
        });
        //点击+号
        $('.increase').click(function(){
            var _this = $(this);
            //库存input框
            var goods_num = _this.parent().prev();
            //购买数量input框
            var buy_num = _this.prev();
            //获取商品id
            var goods_id=_this.parents('tr').attr('goods_id');
            //购买数量
            var buy_number = parseInt(buy_num.val());
            //库存
            var goods_num = parseInt(goods_num.val());
            if(buy_number>=goods_num){
                buy_num.val(goods_num);
            }else{
                buy_num.val(buy_number);
            }
            $.ajax({
                type:'post',
                url:"{{url('/car/update')}}",
                data:{buy_number:buy_number,goods_id:goods_id},
                async:false,
                dataType:'json',
                success:function (res) {
                    if(res.code == 0){
                        alert(res.msg);
                    }
                }
            });
            //调用小计
            gettotal(goods_id,_this,buy_number);
            //调用选中当前行
           changeStatus(_this);
           //    _this.parent().parent().parent().find('.box').attr('checked',true);
            //获取总价
            getcount()
        });
        //点击-号
        $('.decrease').click(function(){
            var _this = $(this);
            var buy_num = _this.next();
            //获取商品id
            var goods_id=_this.parents('tr').attr('goods_id');

            var buy_number = parseInt(buy_num.val());
            if(buy_number<=1){
                buy_num.val(1);
            }else{
                buy_num.val(buy_number);
            }

            $.ajax({
                type:'post',
                url:"{{url('/car/update')}}",
                data:{buy_number:buy_number,goods_id:goods_id},
                async:false,
                dataType:'json',
                success:function (res) {
                    if(res.code == 0){
                        alert(res.msg);
                    }
                }
            });
            changeStatus(_this);
            gettotal(goods_id,_this,buy_number);
            getcount();
        });

        //点击全选
        $('.allbox').click(function(){
            var status = $(".allbox").prop('checked');
            $('.box').prop('checked',status);
            getcount();
        })

        //失去焦点
        $('.spinnerExample').blur(function(){
            var _this = $(this);
            var goods_num = _this.parent().prev();
            var goods_id=_this.parents('tr').attr('goods_id');//商品id
            var buy_num = _this;
            var buy_number = parseInt(buy_num.val());
            var goods_num = parseInt(goods_num.val());
            var reg=/^\d+$/;
            if(buy_number==''||buy_number<=1||!reg.test(buy_number)){
                _this.val(1);
            }else if(buy_number>=goods_num){
                _this.val(goods_num);
            }else{
                buy_number=parseInt(buy_number);
                _this.val(buy_number);
            }
            // console.log(buy_number);
            // return false;
            $.ajax({
                type:'post',
                url:"{{url('/car/update')}}",
                data:{buy_number:buy_number,goods_id:goods_id},
                asyac:false,
                dataType:'json',
                success:function (res) {
                    if(res.code == 0){
                        alert(res.msg);
                    }
                }
            });
            getcount();
        });

        //点击结算
        $('.jiesuan').click(function(){
            var  box = $('.box:checked');
            var goods_id = '';
            $(box).each(function (index) {
                goods_id += $(this).attr('goods_id')+',';
            })
            goods_id = goods_id.substr(0,goods_id.length-1);
           location.href = "{{url('/car/conform')}}?goods_id="+goods_id;
        });
        //选中当前行
        function changeStatus(_this) {
            _this.parents('tr').find('.box').attr('checked',true);
        }
        //计算小计
        function gettotal(goods_id,_this,buy_num) {
            $.ajax({
                url:"/car/gettotal",
                data:{goods_id:goods_id,buy_num:buy_num},
                dataType:'json',
                async:false,
                type:'post',
                success:function (res) {
                    var money = "￥"+res.msg;
                    _this.parents('tr').next('tr').find("strong[class='orange count']").html(money);
                }
            })
        }
        //计算总价
        function getcount(){
            //当前选中的行
            box=$('.box:checked');
            //获取商品id
            var goods_id = '';
            $(box).each(function(index){
                goods_id += $(this).attr('goods_id')+',';
            });
            goods_id=goods_id.substr(0,goods_id.length-1);
            // console.log(goods_id);
            $.ajax({
                url:'/car/getcount',
                data:{goods_id:goods_id},
                dataType:'json',
                type:'post',
                async:false,
                success:function (res) {
                    var count = '￥'+res.count;
                    $('#counts').html(count);
                }
            })
        }
    })
</script>