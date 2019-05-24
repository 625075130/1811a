<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Users;
use DB;

class LoginController extends Controller
{
    //返回注册视图
    public function register()
    {
        return view('login/register');
    }
    //注册的处理
    public function registerHandle()
    {
        $repwd = \request()->repwd;
        $data = \request()->except('repwd');
        if ($data['u_pwd'] != $repwd){
            return ['code'=>1,'msg'=>'两次密码不一致'];
        }
        $data['u_pwd'] = md5($data['u_pwd']);
        $res = Users::insert($data);
        if ($res){
            \request()->session()->forget('code');
            \request()->session()->forget('email');
            return ['code'=>1,'msg'=>'注册成功'];
        }else{
            return ['code'=>0,'msg'=>'注册失败'];
        }
    }
    //发送邮件
    public function sendemail()
    {
        $code = rand('1000','9999');
        $email = \request()->email;
        if(strpos($email,'@') != false){
            //发送邮件
            $result = sendMail($email,$code);
        }else{
           //发送短信
            $result = sendsys($email,$code);
        }
        session(['code'=>$code,'email'=>$email]);
    }
    //验证唯一
    public function checkname()
    {
        $email = \request()->email;
        $count = Users::where('u_email',$email)->count();
        if($count){
            return ['count'=>$count];
        }else{
            return ['count'=>$count];
        }
    }
    //验证验证码
    public function checkcode()
    {
        $email = \request()->email;
        $code = \request()->code;
        if($code == session('code') && $email == session('email')){
            return ['code'=>1];
        }else{
            return ['code'=>0];
        }
    }
    //登陆视图
    public function login()
    {
        return view('/login/login');
    }
    //登陆的处理
    public function loginHandle()
    {
        $data = \request()->all();
        if($data['pwd'] == '' && $data['email'] == ''){
            return ['code'=>0,'msg'=>'请填写邮箱和密码'];
        }
        $count = Users::where('u_email',$data['email'])->count();
        if($count = 0){
            return ['code'=>0,'msg'=>'该邮箱尚未注册'];
        }
        $info = Db::table('user')->where('u_email',$data['email'])->first();
        if($info->u_email == $data['email'] && $info->u_pwd == md5($data['pwd'])){
            session(['u_email'=>$data['email'],'u_pwd'=>$data['pwd'],'u_id'=>$info->u_id]);
            return ['code'=>1,'msg'=>'登陆成功'];
        }else{
            return ['code'=>0,'msg'=>'密码或邮箱不正确'];
        }
    }
    public function loginout()
    {
        $res = \request()->session()->forget('u_id');
        if($res == ''){
            return redirect('/');
        }
    }
}
