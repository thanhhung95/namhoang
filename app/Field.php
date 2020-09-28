<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table 	= 'field';

    protected $fillable = ['category','symbol','name','status'];

    public function Book()
    {
    	return $this->hasMany('App\Book','field','symbol');
    }

   	public function Category()
   	{
   		return $this->hasOne('App\Category','symbol','category');
   	}
}
