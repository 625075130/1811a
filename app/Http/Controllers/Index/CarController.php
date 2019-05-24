<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Car;
use App\Address;

class CarController extends Controller
{
    //加入购物车
    public function addcar()
    {
        //未登录  不让购买
        if(session('u_email') == ''){
            return ['code'=>0,'msg'=>'请先登录'];
        }
        //登陆状态
        $data = \request()->all();
        $u_id = getid();
        $data['u_id'] = $u_id;
        if($data){
            $res = Db::table('car')->where(['u_id'=>$u_id,'goods_id'=>$data['goods_id']])->first();
            if($res){
                //买过 检测库存 做修改
                $result = checknum($data['goods_id'],$data['buy_num'],$res->buy_num);
                if($result){
                    $end = Car::where(['u_id'=>$u_id,'goods_id'=>$data['goods_id']])->update(['buy_num'=>$data['buy_num']+$res->buy_num]);
                }else{
                    return ['code'=>2,'msg'=>'商品库存不足'];
                }
            }else{
                //没买过 检测库存 添加
                $result = checknum($data['goods_id'],$data['buy_num']);
                if($result){
                    $end = Car::create($data);
                }else{
                    return ['code'=>2,'msg'=>'商品库存不足'];
                }
            }
            if($end){
                return ['code'=>1,'msg'=>'加入购物车成功'];
            }
        }
    }
    //购物车列表
    public function index()
    {
        $u_id = session('u_id');
        $count = Car::where('u_id',$u_id)->count();
        $carinfo = Car::join('goods','goods.goods_id','=','car.goods_id')->where(['u_id'=>$u_id,])->get();
//       dd($carinfo);
        $total = [];
        if ($carinfo){
            foreach ($carinfo as $k => $v){;
                $total[] = $v['shop_price']*$v['buy_num'];
            }
            return view('/car/index',compact('count','carinfo','total'));
        }
    }
    //修改购买数量
    public function update()
    {
        $u_id = session('u_id');
        $goods_id = \request()->goods_id;
        $buy_num = \request()->buy_number;
        $info = Car::where(['goods_id'=>$goods_id,'u_id'=>$u_id])->first();
        if ($info){
                $res = DB::table('car')->where(['goods_id'=>$goods_id,'u_id'=>$u_id])->update(['buy_num'=>$buy_num]);
                return ['code'=>1];
        }
    }
    //获取小计
    public function gettotal()
    {
        $goods_id = \request()->goods_id;
        $buy_num = \request()->buy_num;
        if ($goods_id == ''){
            return ['code'=>0,'msg'=>'请选择一件商品'];
        }
        $carinfo = Car::join('goods','goods.goods_id','=','car.goods_id')->where('car.goods_id',$goods_id)->get();
        if ($carinfo){
            //$count = [];
            foreach ($carinfo as $k=>$v){
                $count= $v['shop_price']*$v['buy_num'];
            }
            return ['msg'=>$count];
        }
    }
    //获取总价
    public function getcount()
    {
        $goods_id = \request()->goods_id;
        $u_id = session('u_id');
        $goods_id = explode(',',$goods_id);
        $res = Car::join('goods','goods.goods_id','=','car.goods_id')->whereIn('goods.goods_id',$goods_id)->where('u_id',$u_id)->get();
        if($res){
            $count = [];
            foreach ($res as $k=>$v){
                $count[] += $v->shop_price * $v->buy_num;
            }
            $count = array_sum($count);
            return ['count'=>$count];
        }
    }
    //点击提交订单
    public function conform()
    {
        $goods_id = \request()->goods_id;
        if($goods_id  == ''){
            return "请至少选择一件商品";
        }
        $goods_id = explode(',',$goods_id);
        $info = Car::join('goods','goods.goods_id','=','car.goods_id')->whereIn('car.goods_id',$goods_id)->get();
        $count = [];
        foreach ($info as $k=>$v){
            $count[] .= $v['shop_price']*$v['buy_num'];
        }
        $count = array_sum($count);
        $addressinfo = Address::where(['u_id'=>session('u_id'),'is_del'=>1])->get();
        return view('/car/conform',compact('info','count','addressinfo'));
    }
}
