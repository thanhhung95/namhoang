<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bills;
use App\BillDetail;
use App\BillAddress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BillManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.admin.bill-manage.main');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // Get Bill
        if ($id === 'getDatatable') {
            $status   =     $request->status;
            $bills    =     Bills::query();
            if ($status) {
                $bills->where('status', 'like',$status);
            }
            return datatables($bills->with('BillAddress'))->escapeColumns('name')->make(true);
        }
        // Get Bill Detail
        else {
            $get_bill           =   Bills::with('BillAddress')->find($id); 
            $get_bill_detail    =   BillDetail::where('id_bill',$id)->with('Book')->paginate(5);
            return view('Backend.admin.bill-manage.detail',compact('get_bill','get_bill_detail'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax() && $request->TYPE == 'STATUS') {
            $this->updateItem($request,$id);
            return response()->json([
                'type'=>'success',
                'title' => 'Thành công!',
                'content'=>'Thay đổi trạng thái thành công !!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $temp   =   Bills::find($id);
        $this->delItem($id);
        return response()->json([
            'type'=>'success',
            'title' => 'Thành công!',
            'content'=>'Xóa đơn hàng '.$temp->name.' thành công !!']);
    }
    public function updateItem($request,$id){
        $temp       =   Bills::findOrFail($id);
        $temp->update(['status' => $request->status]);
    }
    public function delItem($id){
        //Del bên bill_detail
        $bill_detail    =  BillDetail::where('id_bill',$id)->delete();
        //Del bên bill_address
        $bill_address   =  BillAddress::where('id_bill',$id)->delete();
        //Del Bill
        $bill =   Bills::destroy($id);
    }
}
