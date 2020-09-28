<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillAddress extends Model
{
    protected $table = 'bill_address';

    protected $fillable = ['id_bill','diachi_quocgia','diachi_tinh','diachi_huyen','diachi_xa','diachi_chitiet','created_at','updated_at'];

    public function Bills(){
    	return $this->belongsTo('App\Bills','id','id_bill');
    }
}
