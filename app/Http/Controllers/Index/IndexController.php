<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Brand;
use App\Goods;

class IndexController extends Controller
{
    public function index()
    {
        $brandinfo = Brand::get();
        $goodsinfo = Goods::get();
        $u_id = session('u_id');
        $u_email = session('u_email');
        return view('index/index',compact('brandinfo','goodsinfo','u_id','u_email'));
    }
    public function addAddress()
    {
        return view('/address/add');
    }
    public function admin()
    {
        return view('/index/admin');
    }
}
