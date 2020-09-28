<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table 	= 'category';

    protected $fillable = ['type_book','symbol','name','status'];

    public function Book()
    {
    	return $this->hasMany('App\Book','category','symbol');
    }

    public function TypeBook()
   	{
   		return $this->hasOne('App\TypeBook','symbol','type_book');
   	}
}
