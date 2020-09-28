<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $table = 'bill_detail';

    protected $fillable = ['id_bill','id_book','quantity','price'];

    public function Book(){
        return $this->hasOne('App\Book','id','id_book');
    }
}
