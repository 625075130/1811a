<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Address;
use App\Area;

class AddressController extends Controller
{
    public function add()
    {
        $info = $this->getAreaInfo(0);
        //dd($info);
        return view('/address/add',compact('info'));
    }
    public function addArea()
    {
        $pid = \request()->id;
        $cityInfo = $this->getAreaInfo($pid);
        return $cityInfo;
    }
    public function getAreaInfo($pid)
    {
        $info = Area::where('pid',$pid)->get();
        return $info;
    }
    public function addHandle()
    {
        $data = \request()->all();
        $data['u_id'] = session('u_id');
        if ($data){
            if ($data['is_default'] == 2){
                //修改并添加
            }else{
                //添加
                $res = Address::create($data);
                if ($res){
                    return ['code'=>1,'msg'=>'添加成功'];
                }else{
                    return ['code'=>2,'msg'=>'添加失败'];
                }
            }
        }
    }
    public function index()
    {
        $addressinfo = Address::where('u_id',session('u_id'))->get();
        return view('/address/index',compact('addressinfo'));
    }

}
