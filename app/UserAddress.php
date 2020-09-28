<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_address';

    protected $fillable = ['id_user','diachi_quocgia','diachi_tinh','diachi_huyen','diachi_xa','diachi_chitiet','created_at','updated_at'];
}
