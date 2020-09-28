<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Field;
use App\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FieldManageController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('name','ASC')->select('name','symbol')->get();
        return view('Backend.admin.field-manage.main',compact('category'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'category'      =>  'required',
                'name'          =>  'required|unique:field,name',
                'symbol'        =>  'required|unique:field,symbol',    
                ],
                $messages = [
                    'category.required'     => 'Bạn chưa thể loại',
                    'name.required'         => 'Bạn chưa nhập tên lĩnh vực.',
                    'name.unique'           => 'Tên lĩnh vực đã tồn tại.',
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
                    'content'=>'Thêm lĩnh vực \''.$request->name.'\' thành công !!']);
            }
        }
        else{
            return response()->json([
                'type'=>'warning',
                'title' => 'Cảnh báo!',
                'content'=>'Không phải ajax request']);
        }
    }
    public function show(Request $request, $id)
    {
        if($request->ajax()){  
            if ($id === 'getDatatable') {
                return datatables(Field::with('Category:type_book,symbol,name')->orderBy('name','ASC')->select('id','category','symbol','name'))->escapeColumns('name')->make(true);
            }
        }
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'category'      =>  'required',
                'name'          =>  'required',
                'symbol'        =>  'required',
                ],
                $messages = [
                    'category.required'     => 'Bạn chưa chọn thể loại',
                    'name.required'         => 'Bạn chưa nhập tên lĩnh vực.',
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
                    'content'=>'Sửa lĩnh vực \''.$request->name.'\' thành công !!']);
            }
        }
        else{
            return response()->json([
                'type'=>'warning',
                'title' => 'Cảnh báo!',
                'content'=>'Không phải ajax request']);
        }
    }
    public function destroy($id)
    {
        $temp   =   Field::find($id);
        $this->delItem($id);
        return response()->json([
            'type'=>'success',
            'title' => 'Thành công!',
            'content'=>'Xóa '.$temp->name.' thành công !!']);
    }
    public function addItem($request)
    {
        $temp   =   Field::create($request->all());
    }
    public function editItem($request, $id)
    {
        $field  =   Field::findOrFail($id);
        //Update bên Book
        $book   =  Book::where('field',$field->symbol)->select('symbol')->update([
            'field' => $request->symbol
        ]);
        //update field
        $field->update($request->all());
    }
    public function delItem($id){
        $field  =   Field::findOrFail($id);
        //Delete bên Book
        $book   =  Book::where('field',$field->symbol)->delete();
        //Delete field
        $field->delete();
    }
}
