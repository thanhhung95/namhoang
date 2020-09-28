<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\UserAddress;
use App\User;

class UserProfileController extends Controller
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
        return view('Backend.users.profile.main',compact('profile','address'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'email'         =>  'email',
                'phone'         =>  'min:10|max:10',
                ],
                $messages = [
                   
                    'email.email'           => 'Email sai',
                    'phone.min'        => 'Số điện thoại không đúng',
                    'phone.max'        => 'Số điện thoại không đúng',
                ]);

            if ($validator->fails()) {
                return response()->json([
                    'type'=>'error',
                    'title' => 'Có lỗi xảy ra!',
                    'content'=>$validator->errors()->first()]);
            }
            else{
                $this->editItem($request,$id);
                return response()->json([
                    'type'=>'success',
                    'title' => 'Thành công!',
                    'content'=>'Thay đổi thông tin cá nhân thành công !!']);
            }
        }
        else{
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
        //
    }
    public function editItem($request, $id){
       
        // update info
        $temp   =   User::find($id);
        $temp->update($request->all());
        // update address
        $address   =   UserAddress::where('id_user',$id)->first();

        if (!$address) {
            UserAddress::create([
                'id_user'           => $id,
                'diachi_quocgia'    => $request->diachi_quocgia,
                'diachi_tinh'       => $request->diachi_tinh,
                'diachi_huyen'      => $request->diachi_huyen,
                'diachi_xa'         => $request->diachi_xa,
                'diachi_chitiet'    => $request->diachi_chitiet,
            ]);
        }
        else{
            $address->update([
            'diachi_quocgia'    => $request->diachi_quocgia,
            'diachi_tinh'       => $request->diachi_tinh,
            'diachi_huyen'      => $request->diachi_huyen,
            'diachi_xa'         => $request->diachi_xa,
            'diachi_chitiet'    => $request->diachi_chitiet,
            ]);
        }
    }
}
