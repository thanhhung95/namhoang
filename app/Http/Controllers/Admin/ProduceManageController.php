<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TypeBook;
use App\Producer;
use App\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProduceManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.admin.producer-manage.main');
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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'name'          =>  'required|unique:producer,name',
                'symbol'        =>  'required|unique:producer,symbol',
                ],
                $messages = [
                    'name.required'         => 'Bạn chưa nhập tên nhà xuất bản.',
                    'name.unique'           => 'Tên nhà xuất bản đã tồn tại.',
                    'symbol.required'       => 'Bạn chưa nhập ký hiệu.',
                    'symbol.unique'         => 'Ký hiệu này đã tồn tại.',
                ]);

            if ($validator->fails()) {
                return response()->json([
                    'type'=>'error',
                    'title' => 'Có lỗi xảy ra!',
                    'content'=>$validator->errors()->first()]);
            }
            else{
                $this->addItem($request);
                return response()->json([
                    'type'=>'success',
                    'title' => 'Thành công!',
                    'content'=>'Thêm nhà xuất bản \''.$request->name.'\' thành công !!']);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->ajax()){  
            if ($id === 'getDatatable') {
                if (Auth::check() && Auth::user()->lever == 1) {
                    return datatables(Producer::orderBy('name','asc'))->escapeColumns('name')->make(true);
                }
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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'name'          =>  'required',
                'symbol'        =>  'required',
                ],
                $messages = [
                    'name.required'         => 'Bạn chưa nhập tên nhà xuất bản.',
                    'symbol.required'       => 'Bạn chưa nhập ký hiệu.',
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
                    'content'=>'Sửa nhà xuất bản \''.$request->name.'\' thành công !!']);
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
        $temp   =   producer::find($id);
        $this->delItem($id);
        return response()->json([
            'type'=>'success',
            'title' => 'Thành công!',
            'content'=>'Xóa nhà xuất bản '.$temp->name.' thành công !!']);
    }
    public function addItem($request)
    {
        $temp   =   Producer::create($request->all());
    }
    public function editItem($request, $id)
    {
        //tim nxb
        $producer   =   Producer::findOrFail($id);
        //Update bên book
        $book       =   Book::where('producer',$producer->symbol)->update([
            'producer' => $request->symbol
        ]);
        //update nxb
        $producer->update($request->all());
    }
    public function delItem($id){
        $producer   =   Producer::findOrFail($id);
        //Update bên book
        $book       =   Book::where('producer',$producer->symbol)->delete();
        //update nxb
        $producer->delete();
    }
}
