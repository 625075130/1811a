<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shangpin;
use DB;
use Illuminate\Support\Facades\Redis;

class ShangpinController extends Controller
{
   //展示
   public function index(){
      $query = request()->all();
        $where = [];
        if ($query['shang_name']??'') {
            $where[]=['shang_name','like',"%$query[shang_name]%"];
        }
      $pageSize = config('app.pageSize');
      $data=DB::table('shangpin')->where($where)->paginate($pageSize);
      return view('shangpin.list',['data'=>$data,'query'=>$query]);
   }

   //添加
   public function create(){
   	return view('shangpin.create');
   }

   //执行商品添加
   public function store(Request $request){
   		$data=$request->except('_token');
   		// dd($data);
         //文件上传
        if($request->hasfile('shang_logo')){
        $res=$this->upload($request,'shang_logo');
            if($res['code']){
                $data['shang_logo']=$res['imgurl'];
            }
        }
        $res=Shangpin::create($data);
        // dd($res);
        if($res){
            //重定向
            return redirect('/shangpin/list');
        } 
   }

      //文件上传方法
   public function upload(Request $request,$file){
        if($request->file($file)->isValid()){
            $photo=$request->file($file);
            $store_result=$photo->store(date('Ymd'));
            // $store_result=$photo->storeAs($file,'test.jpg');
            return ['code'=>1,'imgurl'=>$store_result];
        }else{
            return ['code'=>0,'message'=>'上传过程中出错'];
        }
    }	

   //删除
   public function destroy($id)
   {
        $id=request()->shang_id;
        // dd($news_id);
        $shang=new Shangpin;
        $res=$shang->where('shang_id',$id)->delete();
        if($res){
            return ['code'=>1,'msg'=>'删除成功'];
            Redis::del('shangpin_'.$id);
        }else{
            return ['code'=>0,'img'=>'删除失败'];
        }
   }


   //修改
   public function edit($id)
    {
        $data=DB::table('shangpin')->where('shang_id',$id)->first();
        // dd($data);
        return view('shangpin.edit',['data'=>$data]);
    }


   //执行修改
   public function update(Request $request, $id)
   {
        $data=$request->except('_token');
        // dd($data);
        // 文件上传
        if($request->hasfile('shang_logo')){
            $res=$this->upload($request,'shang_logo');
            if($res['code']){
                $data['shang_logo']=$res['imgurl'];
            }
        }
        $res=Shangpin::where('shang_id',$id)->update($data);
        if($res){
            return redirect('shangpin/list');
        }
    }

   //详情
   public function xiangqing(Request $request,$id){
        $data=cache('shangpin_'.$id);
        if(!$data){
         echo 123;
            $data=DB::table('shangpin')->where('shang_id',$id)->first();
            // dd($data);
            cache(['shangpin_'.$id=>$data],1);
        }
        //访问量
        if(Redis::exists('num')){
            $num=Redis::incr('num');
        }else{
            $num=Redis::set('num',1);
        }
        return view('shangpin.xiangqing',['data'=>$data,'num'=>$num]);
   }

}
