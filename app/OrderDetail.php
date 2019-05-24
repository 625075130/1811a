<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    protected $fillable = [
        'goods_id',
        'goods_name',
        'shop_price',
        'buy_number',
        'goods_img',
        'order_id',
        'u_id',
    ];
}
