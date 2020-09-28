<?php

namespace App\Http\Controllers\Excell;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

//using modal
use App\Book;

//using export
use App\Exports\ExportBillsUser;
use App\Exports\ExportBookAll;
use App\Exports\ExportBookType;
use App\Exports\ExportCart;

class ExportController extends Controller
{
    public function __construct(){
        $this->time = Carbon::now()->isoFormat('D-M-YYYY');
    }

    public function show($id, $type)
    {

        switch ($type) {
            case 'BOOK';
                return $this::exportBook($id);
                break;
            case 'BILL';
                return $this::exportBill($id);
                break;
            case 'CART';
                return $this::exportCart($id);
                break;
            default:
                # code...
                break;
        }
    }
    public function exportBook($id){
        if ($id == 'GET_ALL') {
            return  Excel::download(new ExportBookAll(),$id.' '.$this->time.'.xlsx');
        }
        else{
            return (new ExportBookType($id))->download($id.' '.$this->time.'.xlsx');
        }
    }
    public function exportBill($id){
        return (new ExportBillsUser($id))->download('invoice '.$this->time.'.xlsx');
    }
    public function exportCart($id){
        return (new ExportCart($id))->download('listbook'.$this->time.'.xlsx');
    }
}
