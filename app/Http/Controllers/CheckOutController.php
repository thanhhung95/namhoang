<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//library
use Response;
use Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
//modal
use App\UserAddress;
use App\Bills;
use App\BillDetail;
use App\BillAddress;

class CheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile    =   Auth::user();
        $address    =   UserAddress::where('id_user',$profile->id)->first();
        return view("Backend.checkout.main",compact('profile','address'));
    }
    
    public function store(Request $request)
    {
         // check 
            $validator = Validator::make($request->all(), [
                'id_user'           =>  'required',
                'name'              =>  'required',
                'phone'             =>  'required|min:10|max:10',
                'email'             =>  'required',
                'diachi_quocgia'    =>  'required',
                'diachi_tinh'       =>  'required',
                'diachi_huyen'      =>  'required',
                'diachi_xa'         =>  'required',
                'diachi_chitiet'    =>  'required',
            ],
            $messages = [
                'name.required'           => 'Bạn chưa nhập tên',
                'phone.required'          => 'Bạn chưa nhập số điện thoại.',
                'phone.min'               => 'Số điện thoại không đúng',
                'phone.max'               => 'Số điện thoại không đúng',
                'email.required'          => 'Bạn chưa nhập email',
                'diachi_quocgia.required' => 'Bạn chưa chọn địa chỉ',
                'diachi_tinh.required'    => 'Bạn chưa chọn địa chỉ',
                'diachi_huyen.required'   => 'Bạn chưa chọn địa chỉ',
                'diachi_xa.required'      => 'Bạn chưa chọn địa chỉ',
                'diachi_chitiet.required' => 'Bạn chưa nhập địa chỉ',
            ]);
        // Error
        if($validator->fails()){
            return back()->with('BillError',$validator->errors()->first());
        }

        // Thông tin khách đặt hàng
        $id_user     =   $request->id_user;
        $name        =   $request->name;
        $phone       =   $request->phone;
        $email       =   $request->email;
        $description =   $request->description;
        // dia chi
        $quocgia     =   $request->diachi_quocgia;
        $tinh        =   $request->diachi_tinh;
        $huyen       =   $request->diachi_huyen;
        $xa          =   $request->diachi_xa;
        $chitiet     =   $request->diachi_chitiet;
        
        //Thông tin gio hang
        $getCart     =   Cart::session($id_user)->getContent();
        $getSubTotal =   Cart::session($id_user)->getSubTotal();
        
        //Check user có địa chỉ mặc định chưa
        $check_user  =   UserAddress::where('id_user',$id_user)->get();

        //  Lưu đơng hàng
        $bills = Bills::create([
                'id_user'       =>  $id_user,
                'name'          =>  $name,
                'email'         =>  $email,
                'phone'         =>  $phone,
                'time_bill'     =>  Carbon::now(),
                'total'         =>  $getSubTotal,
                'description'   =>  $description,
                'status'        =>  1,   
            ]);
        //  Lưu địa chỉ đơn hàng
        $bill_address   =   BillAddress::create([
                'id_bill'           =>  $bills->id,
                'diachi_quocgia'    =>  $quocgia,
                'diachi_tinh'       =>  $tinh,
                'diachi_huyen'      =>  $huyen,
                'diachi_xa'         =>  $xa,
                'diachi_chitiet'    =>  $chitiet,
            ]);
        // Nếu user chưa có địa chỉ thì lưu địa chỉ user
        if (!$check_user) {
            $user_address   =   UserAddress::create([
                'id_user'           =>  $id_user,
                'diachi_quocgia'    =>  $quocgia,
                'diachi_tinh'       =>  $tinh,
                'diachi_huyen'      =>  $huyen,
                'diachi_xa'         =>  $xa,
                'diachi_chitiet'    =>  $chitiet,
            ]);
        }
        //  Lưu thông tin chi tiết đơn hàng
        foreach ($getCart as $key => $value) {            
            $billDetail              = new BillDetail;
            $billDetail->id_bill     = $bills->id ;
            $billDetail->id_book     = $value->id;
            $billDetail->quantity    = $value->quantity;
            $billDetail->price       = $value->price;
            $billDetail->save();
        }
        //  Đặt thành công xóa giỏ hàng
        Cart::session($id_user)->clear(); 
        return view('Backend.checkout.success');
    }
}
