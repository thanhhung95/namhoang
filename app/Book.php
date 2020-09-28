<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table 	= 'book';

    protected $fillable = ['macty','book_code','type_book','field','category','name','author','producer','producer_year','page','size','price','creator','link','status'];

    // public $timestamps = false;
    public function TypeBook(){
        return $this->hasOne('App\TypeBook','symbol','type_book');
    }
    public function Category(){
        return $this->hasOne('App\Category','symbol','category');
    }
    public function Field(){
        return $this->hasOne('App\Field','symbol','field');
    }
    public function Producer(){
        return $this->hasOne('App\Producer','symbol','producer');
    }
}
