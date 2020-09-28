<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Cart;
class ExportCart implements FromView
{
    use Exportable;

    public function __construct(string $id)
    {
    	//id khách hàng get từ bên controller
    	$this->id = $id;
    }
	public function view(): View
	{
		//get thông tin cart theo id khách
		$cart 	=	Cart::session($this->id)->getContent();
		return view('Backend.export.cart',compact('cart'));
	}
}
