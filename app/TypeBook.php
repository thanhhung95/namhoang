<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeBook extends Model
{
    protected $table = 'type_book';

    protected $fillable = ['symbol','name','status'];

    public function Book()
    {
    	return $this->hasMany('App\Book','type_book','symbol');
    }
}
