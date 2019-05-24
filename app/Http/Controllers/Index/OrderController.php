<?php

namespace App\Http\Controllers\Index;

use App\OrderAddress;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Car;
use App\Goods;
use App\Address;
use DB;
use PhpParser\Node\Stmt\TryCatch;
use App\Exceptions\Handler;

class OrderController extends Controller
{
    public  function addOrder()
    {
        $goods_id = \request()->goods_id;
        $address_id = \request()->address_id;
        DB::beginTransaction();
        try{
            if(empty($goods_id)){
                return ['code'=>2,'msg'=>'请至少选择一件商品'];
            }
            if(empty($address_id)){
                return ['code'=>2,'msg'=>'请选择一个收货地址'];
            }
            $data['order_no'] = $this->getOrderNo();
            $data['order_amount'] = $this->getAmount($goods_id);
            $data['u_id'] = session('u_id');
            $data['created_at'] = time();
            $data['updated_at'] = time();
            //向Order表中添加数据 并获得自增ID
            $order_id = DB::table('order')->insertGetId($data);
            $res2 = $this->saveOrderAddressDb($address_id,$order_id);
            $res3 = $this->saveOrderDetailDb($goods_id,$order_id);
            $res4 = $this->editBuyNum($goods_id,$order_id);
            $res5 = $this->editCar($goods_id,$order_id);
            DB::commit();
            return ['code'=>1,'msg'=>'下单成功','order_id'=>$order_id];
        }catch (Exception $a){
            //抛出错误信息（回滚）
            DB::rollBack();
            report($a);
        }
    }
    //获取订单号
    public function getOrderNo()
    {
        $u_id = session('u_id');
        $no = time().rand(1000,999).$u_id;
        return $no;
    }
    //获取总金额
    public function getAmount($goods_id)
    {
        $goods_id = explode(',',$goods_id);
        $u_id = session('u_id');
        $where = [
          ['u_id','=',$u_id],
          ['is_del','=',1],
        ];
        $info = Car::join('goods','goods.goods_id','=','car.goods_id')->where($where)->whereIn('car.goods_id',$goods_id)->get();
        $money = [];
        foreach ($info as $k=>$v){
            $money[] += $v['shop_price']*$v['buy_num'];
        }
        $money = array_sum($money);
        return $money;
    }

    public function saveOrderAddressDb($address_id,$order_id)
    {
        $where = [
          'address_id'=>$address_id,
          'is_del'=>1
        ];
        $info = Address::where($where)->get()->toArray();
        if(!empty($info)){
            unset($info[0]['updated_at']);
            unset($info[0]['created_at']);
            $info[0]['order_id'] = $order_id;
            $res = OrderAddress::create($info);
            if(!$res){
                return ['写入地址信息失败'];
            }
        }else{
            return ['无效的收货地址'];
        }
    }
    //往order_detail添加数据
    public  function saveOrderDetailDb($goods_id,$order_id)
    {
        $goods_id = explode(',',$goods_id);
        $where = [
          'u_id'=>session('u_id'),
          'is_del'=>1
        ];
        $info = Goods::join('car','car.goods_id','=','goods.goods_id')->where($where)->whereIn('car.goods_id',$goods_id)->get()->toArray();
        if(!empty($info)){
            foreach($info as $k=>$v){
                $info[$k]['buy_number'] = $v['buy_num'];
                $info[$k]['order_id'] = $order_id;
                unset($info[$k]['created_at']);
                unset($info[$k]['updated_at']);
            }
            $res = OrderDetail::create($info);
            if(!$res){
                return ['code'=>2,'msg'=>'写入信息失败'];
            }
        }else{
            return ['code'=>2,'msg'=>'没有找到商品信息'];
        }
    }
    //修改商品数量
    public  function editBuyNum($goods_id,$order_id)
    {
        $goods_id = explode(',',$goods_id);
        $where = [
          'u_id' => session('u_id'),
          'is_del' => 1
        ];
        $info = goods::join('car','car.goods_id','=','goods.goods_id')->where($where)->whereIn('car.goods_id',$goods_id)->get()->toArray();
        foreach ($info as $k=>$v){
            $res = goods::where('goods_id',$v['goods_id'])->decrement('goods_number',$v['buy_num']);
        }
        if(empty($res)){
            return ['code'=>2,'msg'=>'修改失败'];
        }
    }
    //清空购物车
    public  function editCar($goods_id,$order_id)
    {
        $goods_id = explode(',',$goods_id);
        $where = [
            'u_id'=>session('u_id'),
        ];
        $res = Car::where($where)->whereIn('goods_id',$goods_id)->update(['is_del'=>2]);
        if(empty($res)){
            return ['code'=>2,'msg'=>'清空购物车失败'];
        }
    }
    //下单成功后的跳转
    public  function successOrder()
    {
        $order_id = \request()->order_id;
        $data = Order::where('order_id',$order_id)->first();
        return view('/order/success',compact('data'));
    }
}
