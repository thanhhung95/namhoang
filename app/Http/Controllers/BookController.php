<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Category;
use App\Field;
use App\Producer;
use App\TypeBook;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        
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
    public function show(Request $request,$id)
    {
        if($request->ajax()){  
            if ($id === 'getDatatable') {

                $id_type_book   =   $request->id_type_book;
                $id_field       =   $request->id_field;
                $id_category    =   $request->id_category;
                $id_producer    =   $request->id_producer;
    
                $book           =   Book::query();

                if ($id_type_book) {
                    $book->where('type_book',$id_type_book);
                }
                if($id_field){
                    $book->where('field',$id_field);
                }
                if($id_category){
                    $book->where('category',$id_category);
                }
                if($id_producer){
                    $book->where('producer',$id_producer);
                }
                // Admin get full book
                if (Auth::check() && Auth::user()->lever == 1) {
                    return datatables($book->with(['Field:symbol,name','Category:symbol,name','Producer:symbol,name'])->select('id','type_book','category','field','book_code','name','author','producer','producer_year','page','size','price','status'))->escapeColumns(['name','author'])->make(true);
                }
                //Khach get book status 1
                return datatables($book->where('status',1)->with('Producer:symbol,name')->select('id','book_code','name','author','producer','producer_year','page','price','status'))->escapeColumns(['name','author'])->make(true);
            }
            if ($id === 'getFormEdit') {
                $type_book  =   TypeBook::select('symbol','name')->get();
                $category   =   Category::select('symbol','name')->get();
                $field      =   Field::select('symbol','name')->get();
                $producer   =   Producer::select('symbol','name')->get();    
                return view('Backend.sachnoi.form',compact('type_book','category','field','producer'));
            }
        }
        //Check Loại sách là sách nội hay sách ngoại
        if ($id) {
            $get_type_book  =   TypeBook::where('symbol',$id)->first();
            return view('Backend.sachnoi.main',compact('get_type_book'));
        }
    }

    public function edit($id)
    {
        //
    }
    
    public function update(Request $request, $id)
    {
        $reatime = Carbon::now()->format('Y');

        if ($request->ajax()){
            /* Sửa sản phẩm */
                $validator = Validator::make($request->all(), [
                    'type_book'         =>  'required',
                    'status'            =>  'required',
                    'field'             =>  'required',
                    'category'          =>  'required',
                    'name'              =>  'required',
                    'producer_year'     =>  'numeric|min:0|max:'.$reatime,
                    'page'              =>  'min:0',
                    'price'             =>  'numeric|min:0',
                ],
                $messages = [
                    'type_book.required'    => 'Bạn chưa chọn loại sách.',
                    'status.required'       => 'Bạn chưa chọn trạng thái.',
                    'field.required'        => 'Bạn chưa chọn lĩnh vực.',
                    'category.required'     => 'Bạn chưa chọn thể loại.',
                    'name.required'         => 'Bạn chưa nhập tên.',
                    'producer_year.numeric' => 'Bạn chưa nhập năm xuất bản',
                    'producer_year.min'     => 'Năm xuất bản phải lớn hơn 1970',
                    'producer_year.max'     => 'Năm xuất bản bằng hoặc nhỏ hơn '.$reatime,
                    'page.min'              => 'Số trang phải lớn hơn 0',
                    'price.numeric'         => 'Bạn chưa nhập giá',
                ]);
            if($validator->fails()){
                return response()->json([
                    'type'=>'error',
                    'title' => 'Có lỗi xảy ra!',
                    'content'=>$validator->errors()->all()]);
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
        $temp   =   Book::find($id);
        $this->delItem($id);
        return response()->json([
            'type'=>'success',
            'title' => 'Thành công!',
            'content'=>'Xóa '.$temp->name.' thành công !!']);
    }
    public function editItem($request,$id){
        $temp   =   Book::findOrFail($id);
        $temp->update($request->all());
    }
    public function delItem($id){
        $temp   =   Book::destroy($id);
    }
}
