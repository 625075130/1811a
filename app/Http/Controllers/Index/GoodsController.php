<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Goods;
use App\Talk;

class GoodsController extends Controller
{
    public function index()
    {
        $brand_id = \request()->brand_id;
        if($brand_id == ''){
            $goodsinfo = Goods::get();
        }else{
            $goodsinfo = Goods::where('brand_id',$brand_id)->get();
        }
        return view('/goods/index',compact('goodsinfo'));
    }
    public function goodsinfo()
    {
        $goods_id = \request()->goods_id;
        $page = \request()->page??1;
        $goodsinfo = cache('goodsinfo_'.$goods_id);
        if(!$goodsinfo){
            echo 12;
            $goodsinfo = Goods::where('goods_id',$goods_id)->first();
            cache(['goodsinfo_'.$goods_id=>$goodsinfo],20);
        }
        $talkinfo = cache('talkinfo_'.$goods_id.'_'.$page);
//        dd($talkinfo);
        if(!$talkinfo){
            echo 33;
            $page = config('app.pageSize');
            $talkinfo = Talk::where('goods_id',$goods_id)->paginate($page);
            cache(['talkinfo_'.$goods_id.'_'.$page=>$talkinfo],2*60);
        }
        if(\request()->ajax()){
            return view('/goods/ajaxpage',compact('goodsinfo','talkinfo'));
        }
        return view('/goods/goodsinfo',compact('goodsinfo','talkinfo'));
    }
    public function talkAdd()
    {
        $data = \request()->all();
        if($data['u_email'] == ''){
            return ['code'=>2,'msg'=>'邮箱必填'];
        }
        if($data['level'] == ''){
            return ['code'=>2,'msg'=>'请选择一个评论等级'];
        }
        if($data['desc'] == ''){
            return ['code'=>2,'msg'=>'请填写评论'];
        }
        $res = Talk::create($data);
        $info = Talk::where('goods_id',$data['goods_id'])->orderby('created_at','desc')->first();
        if($res){
            return ['code'=>1,'msg'=>'评论成功','info'=>$info];
        }
    }
}
