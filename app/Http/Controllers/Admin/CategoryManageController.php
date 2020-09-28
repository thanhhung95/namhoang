<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TypeBook;
use App\Category;
use App\Field;
use App\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoryManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_book = TypeBook::orderBy('id','ASC')->get();
        return view('Backend.admin.category-manage.main',compact('type_book'));
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
                'type_book'  =>  'required',
                'name'          =>  'required|unique:category,name',
                'symbol'        =>  'required|unique:category,symbol',
                ],
                $messages = [
                    'type_book.required' => 'Bạn chưa chọn loại sách',
                    'name.required'     => 'Bạn chưa nhập tên thể loại.',
                    'name.unique'       => 'Tên thể loại đã tồn tại.',
                    'symbol.required'   => 'Bạn chưa nhập ký hiệu.',
                    'symbol.unique'     => 'Ký hiệu này đã tồn tại.',
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
                    'content'=>'Thêm thể loại \''.$request->name.'\' thành công !!']);
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
                return datatables(Category::with('TypeBook')->select('id','type_book','symbol','name'))->escapeColumns('name')->make(true);
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
                'type_book'  =>  'required',
                'name'          =>  'required',
                'symbol'        =>  'required',
                ],
                $messages = [
                    'type_book.required' => 'Bạn chưa chọn loại sách',
                    'name.required'         => 'Bạn chưa nhập tên thể loại.',
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
                    'content'=>'Sửa thể loại \''.$request->name.'\' thành công !!']);
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
        $temp   =   Category::find($id);
        $this->delItem($id);
        return response()->json([
            'type'=>'success',
            'title' => 'Thành công!',
            'content'=>'Xóa '.$temp->name.' thành công !!']);
    }
    public function addItem($request)
    {
        $temp   =   Category::create($request->all());
    }
    public function editItem($request, $id)
    {
        $temp   =   Category::findOrFail($id);
        //Update bên Field
        $field   =   Field::where('category',$temp->symbol)->update([
            'category'  =>  $request->symbol,
        ]);      
        //Update bên Book
        $book   =  Book::where('category',$temp->symbol)->update([
            'category' => $request->symbol
        ]);
        //update category
        $temp->update($request->all());
    }
    public function delItem($id){
        $temp   =   Category::findOrFail($id);
        //Update bên Field
        $field   =   Field::where('category',$temp->symbol)->delete();      
        //Update bên Book
        $book   =  Book::where('category',$temp->symbol)->delete();
        //update category
        $temp->delete();
    }
}
