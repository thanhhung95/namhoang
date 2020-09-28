<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    protected $table = 'producer';

    protected $fillable = ['type_book','category','field','symbol','name','phone','address','website','email','type','status'];
    
    public function Book()
    {
    	return $this->hasMany('App\Book','producer','symbol');
    }

    public function TypeBook()
    {
    	return $this->hasOne('App\TypeBook','id','type_book');
    }
}
