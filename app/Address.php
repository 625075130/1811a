<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = [
        'address_name',
        'address_detail',
        'province',
        'city',
        'area',
        'address_tel',
        'is_default',
        'u_id'
    ];
}
