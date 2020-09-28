<?php

namespace App\Exports;

use App\BillDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ExportBillsUser implements FromView
{
	use Exportable;
	public function __construct(int $id_bill)
    {
        $this->id_bill = $id_bill;
    }

    public function view(): View
    {
        $bill_detail 	=	BillDetail::where('id_bill',$this->id_bill)->with('Book')->get();
        return view('Backend.export.user-bill-detail',compact('bill_detail'));
    }
}
