<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Book;

class ExportBookAll implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    public function __construct(){
    	set_time_limit(0);
		ini_set('memory_limit', '2000M');
	}
	public function headings(): array
	{
		return [
			'macty',
            'loaisach',
            'theloai',
            'linhvuc',
            'masach',
            'tensach',
            'tacgia',
            'nxb',
            'namxb',
            'trang',
            'kichthuoc',
            'gia',
            'nguoitao',
            'nguon',
		];
	}
    public function query()
    {
        return $book = Book::query()->with(['TypeBook:symbol,name','Category:symbol,name','Field:symbol,name','Producer:symbol,name'])->select('macty','type_book','category','field','book_code','name','author','producer','producer_year','page','size','price','creator','link');
    }
    //get $book tu query
    public function map($book): array
    {
        dd($book);
        return [
            $book->macty,
            $book->TypeBook->name,
            $book->Category->name,
            $book->Field->name,
        	$book->book_code,
            $book->name,
            $book->author,
            $book->Producer->name,
            $book->producer_year,
            $book->page,
            $book->size,
            $book->price,
            $book->creator,
            $book->link,
        ];
    }
}
