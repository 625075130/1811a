<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shangpin extends Model
{
    protected $primarykey="shang_id";
    public $timestamps=true;
    const CREATED_AT='create_time';
    const UPDATED_AT='update_time';
    protected $table='shangpin';
    protected $fillable=[
    	'shang_name',
    	'shang_logo',
    	'shang_num',
    	'shang_desc',
    ];
}
