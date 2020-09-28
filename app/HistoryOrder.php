<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryOrder extends Model
{
    protected $table = 'history_order';

    protected $fillable = ['id_user','id_book','quantity','price','time_order','producer'];
}
