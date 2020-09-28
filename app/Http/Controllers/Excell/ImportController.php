<?php

namespace App\Http\Controllers\Excell;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Book;
use App\Imports\ImportBook;
use App\Imports\Import;
use App\Imports\ImportType;
use App\Imports\ImportCollection;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function Import(Request $request){
        $rule   =   ['file'     => 'required|file|mimes:xlsx'];

        $customeMessage     =   [
            'file.required' =>  'Bạn chưa chọn file',
            'file.mimes'    =>  'Không đúng kiểu file'
        ];

        $validator = Validator::make($request->all(),$rule,$customeMessage);

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator);
        }

        switch ($request->type) {
            case 'IMPORT_BOOK':
                return $this->importBook($request->file);
            case 'BACK_UP':
                return $this->backUp($request->file);
            case 'EDIT_BOOK':
                return $this->editBook($request->file);
            default:
                break;
        }
    }
    public function importBook($file){

        $import = new ImportBook();
        $import->import($file);
        return redirect('/');
    }
    public function backUp($file){
        $import = new ImportCollection();
        Excel::import($import,$file);
        return redirect('/');
    }
    public function editBook($file){
        $rows = Excel::toCollection(new ImportBook,request()->file('file'));
        foreach ($rows[0] as $key => $row) {
            Book::where('macty',$row['macty'])->update([
                    'price' =>  $row['gia']]);
        }
        return redirect()->back();
    }
}

