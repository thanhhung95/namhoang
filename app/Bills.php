<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    protected $table = 'bills';

    protected $fillable = ['id_user','name','email','phone','time_bill','total','payment','description','status'];

    public function User(){
        return $this->hasOne('App\User','id','id_user');
    }
    public function BillDetail(){
        return $this->hasMany('App\BillDetail','id_bill','id');
    }
    public function BillAddress(){
        return $this->hasOne('App\BillAddress','id_bill','id');
    }
}
