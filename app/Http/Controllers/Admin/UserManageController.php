<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserAddress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('Backend.admin.user-manage.main');
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
        if ($request->ajax()){
            /* Sửa sản phẩm */
                $validator = Validator::make($request->all(), [
                    'name'         =>   'required',
                    'phone'        =>   'min:10|numeric|unique:users,phone',
                    'password'     =>   'required|min:8',
                    'email'        =>   'required|unique:users,email',
                    'lever'        =>   'required',
                    'status'       =>   'required',
                ],
                $messages = [
                    'name'              =>  'Bạn chưa nhập họ và tên',
                    'phone.min'         =>  'Số điện thoại không đúng',
                    'phone.numeric'     =>  'Bạn chưa nhập số điện thoại',
                    'phone.unique'      =>  'Số điện thoại đã có người sử dụng',
                    'password.required' =>  'Bạn chưa nhập mật khẩu',
                    'password.min'      =>  'Password tối thiểu 8 kí tự',
                    'email.required'    =>  'Bạn chưa nhập email',
                    'email.unique'      =>  'Email đã có người sử dụng',
                    'lever.required'    =>  'Bạn chưa chọn lever',
                    'status.required'   =>  'Bạn chưa chọn trạng thái',
                ]);
            if($validator->fails()){
                return response()->json([
                    'type'=>'error',
                    'title' => 'Có lỗi xảy ra!',
                    'content'=>$validator->errors()->first()]);
            } else{
                $this->addItem($request);
                return response()->json([
                    'type'=>'success',
                    'title' => 'Thành công!',
                    'content'=>'Thêm \''.$request->name.'\' thành công !!']);
            }
        }else{
            return response()->json([
                'type'=>'warning',
                'title' => 'Cảnh báo!',
                'content'=>'Không phải ajax request']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->ajax()){  
            if ($id === 'getDatatable') {
                $users    =   User::query();
                return datatables($users->with('UserAddress'))->escapeColumns('name')->make(true);
            }
            if ($id === 'getFormUser') {
                return view('Backend.admin.user-manage.form');
            }
            if ($id === 'getEditUser') {
                return view('Backend.admin.user-manage.edit');
            }
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
        if ($request->ajax()){
            if ($request->type == "INFO") {     //Update thông tin user
                $validator = Validator::make($request->all(), [
                    'lever'        =>  'required',
                    'status'       =>  'required',
                ],
                $messages = [
                    'lever.required'    => 'Bạn chưa chọn lever',
                    'status.required'   => 'Bạn chưa chọn trạng thái',
                ]);
            }
            if ($request->type == "PASSWORD") {     //Update password
                $validator = Validator::make($request->all(), ['password' => 'required|min:8',],
                $messages = [
                    'password.required' => 'Bạn chưa nhập password',
                    'password.min'      => 'Password tối thiểu 8 kí tự',
                ]);
            }
            if($validator->fails()){
                return response()->json([
                    'type'=>'error',
                    'title' => 'Có lỗi xảy ra!',
                    'content'=>$validator->errors()->first()]);
            } else{
                $this->editItem($request,$id);
                return response()->json([
                    'type'=>'success',
                    'title' => 'Thành công!',
                    'content'=>'Sửa \''.$request->name.'\' thành công !!']);
            }
        }else{
            return response()->json([
                'type'=>'warning',
                'title' => 'Cảnh báo!',
                'content'=>'Không phải ajax request']);
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
        $temp   =   User::find($id);
        $this->delItem($id);
        return response()->json([
            'type'=>'success',
            'title' => 'Thành công!',
            'content'=>'Xóa '.$temp->email.' thành công !!']);
    }
    public function editItem($request, $id)
    {
        $info_user   =   User::findOrFail($id);
        if ($request->type == "INFO") {     // cập nhật thông tin user
            $info_user->update([
                'name'  =>  $request->name,
                'email' =>  $request->email,
                'phone' =>  $request->phone,
                'lever'     =>  $request->lever,
                'status'    =>  $request->status,
            ]);
            $address_user   =   UserAddress::where('id_user',$id)->first();
            if (!$address_user) {
                $address_user   =   UserAddress::create([
                    'id_user'           =>  $info_user->id,
                    'diachi_quocgia'    =>  $request->diachi_quocgia,
                    'diachi_tinh'       =>  $request->diachi_tinh,
                    'diachi_huyen'      =>  $request->diachi_huyen,
                    'diachi_xa'         =>  $request->diachi_xa,
                    'diachi_chitiet'    =>  $request->diachi_chitiet,
                ]);
            }
            $address_user->update([
                'id_user'           =>  $info_user->id,
                'diachi_quocgia'    =>  $request->diachi_quocgia,
                'diachi_tinh'       =>  $request->diachi_tinh,
                'diachi_huyen'      =>  $request->diachi_huyen,
                'diachi_xa'         =>  $request->diachi_xa,
                'diachi_chitiet'    =>  $request->diachi_chitiet,
            ]);
        }
        if ($request->type == "PASSWORD") {     // cập nhật password
           $info_user->update([
            'password'  =>  bcrypt($request->password),
            ]);
        }
    }
    public function addItem($request)
    {
        $info_user  =   User::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'phone' =>  $request->phone,
            'password'  =>  bcrypt($request->password),
            'provider'  =>  'website',
            'lever'     =>  $request->lever,
            'status'    =>  $request->status,
        ]);
        $address_user   =   UserAddress::create([
            'id_user'           =>  $info_user->id,
            'diachi_quocgia'    =>  $request->diachi_quocgia,
            'diachi_tinh'       =>  $request->diachi_tinh,
            'diachi_huyen'      =>  $request->diachi_huyen,
            'diachi_xa'         =>  $request->diachi_xa,
            'diachi_chitiet'    =>  $request->diachi_chitiet,
        ]);
    }
    public function delItem($id){
        $temp   =   User::destroy($id);
    }
}
