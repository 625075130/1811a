<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'car';
    protected $fillable = [
        'goods_id',
        'buy_num',
        'u_id',
    ];
//    public $timestamps = false;
}
