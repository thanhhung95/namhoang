<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Field;
use App\Category;
use App\TypeBook;
use App\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TypeBookManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.admin.typebook-manage.main');
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
                'name'      =>  'required|unique:type_book,name',
                'symbol'    =>  'required|unique:type_book,symbol',
                ],
                $messages = [
                    'name.required'     => 'Bạn chưa nhập tên loại sách.',
                    'name.unique'       => 'Tên loại sách đã tồn tại.',
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
                    'content'=>'Thêm loại sách \''.$request->name.'\' thành công !!']);
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
                $type_book    =   TypeBook::query();
                if (Auth::check() && Auth::user()->lever == 1) {
                    return datatables($type_book->select('id','symbol','name'))->escapeColumns('name')->make(true);
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
                'name'      =>  'required',
                'symbol'    =>  'required',
                ],
                $messages = [
                    'name.required'     => 'Bạn chưa nhập tên loại sách.',
                    'symbol.required'   => 'Bạn chưa nhập ký hiệu.',
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
                    'content'=>'Sửa loại sách \''.$request->name.'\' thành công !!']);
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
        $temp   =   TypeBook::find($id);
        $this->delItem($id);
        return response()->json([
            'type'=>'success',
            'title' => 'Thành công!',
            'content'=>'Xóa '.$temp->name.' thành công !!']);
    }
    public function addItem($request)
    {
        $temp   =   TypeBook::create($request->all());
    }
    public function editItem($request, $id)
    {
        //Tim loại sách
        $temp   =   TypeBook::find($id);
        //Update bên category
        $category   =   Category::where('type_book',$temp->symbol)->update([
            'type_book' =>  $request->symbol
        ]);   
        //Update bên book
        $book   =  Book::where('type_book',$temp->symbol)->update([
            'type_book' => $request->symbol
        ]);
        //Update bên typebook
        $temp->update($request->all());
    }
    public function delItem($id){
        //Loại sách
        $temp   =   TypeBook::find($id);
        //Get Category
        $category_array   =   Category::where('type_book',$temp->symbol)->select('symbol')->get(); 
        //Del bên Field
        $field      =   Field::whereIn('category',$category_array)->delete();
        //Del bên Category
        $category   =   Category::where('type_book',$temp->symbol)->delete();
        //Del bên book
        $book   =  Book::where('type_book',$temp->symbol)->delete();
        //Del Typebook
        $temp->delete();
    }
}
