<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $table = 'order_address';
    protected $fillable = [
        'address_name',
        'address_tel',
        'address_detail',
        'province',
        'city',
        'area',
        'order_id',
        'u_id',
    ];
}
