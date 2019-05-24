<?php
//第二种发邮件方式(发送一个视图)
function sendMaila($email,$code)
{
    \Mail::send('email',[],function ($message)use($email){
        $message->subject("阿晨");
        $message->to($email);
    });
}
//第二种发邮件方式(只发送内容)
function sendMail($email,$code)
{
    \Mail::raw('你的验证码为'."$code".'请妥善保管，打死不要说',function ($message)use($email){
        $message->subject("阿晨");
        $message->to($email);
    });
}
//发送短信
function sendsys($mobile,$code)
{

    $host = "http://dingxin.market.alicloudapi.com";
    $path = "/dx/sendSms";
    $method = "POST";
    $appcode = "aadedb0a7a5e4f68a6c4c6fb65110338";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $querys = "mobile=$mobile&param=code%3A$code&tpl_id=TP1711063";
    $bodys = "";
    $url = $host . $path . "?" . $querys;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    var_dump(curl_exec($curl));
}
//检测库存
/*
 * $goods_id 商品ID
 * $goods_num 要购买的数量
 * $buy_num 已经购买的数量
 */
function checknum($goods_id,$goods_num,$buy_num=0)
{
    $goodsinfo = \DB::table('goods')->where('goods_id',$goods_id)->first();
    $num = $buy_num + $goods_num;
    if($goodsinfo->goods_number < $num){
        return false;
    }else{
        return true;
    }
}
//获取用户ID
function getid()
{
    return session('u_id');
}