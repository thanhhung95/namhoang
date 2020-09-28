<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Field;
use App\Producer;
use App\Book;
class FilterController extends Controller
{
    public function Show(Request $request)
    {
    	if ($request->ajax()) {
    		switch ($request->type) {
    			case 'CATEGORY':
    				return $this::showCategory($request);
    				break;
    			case 'FIELD':
    				return $this::showField($request);
    				break;
                case 'PRODUCER':
                    return $this::showProducer($request);
                    break;
    			default:
    				return $this::getField($request);
    				break;
    		}
    	}
    }
    public function showCategory($request){

    	$check	=	Category::where('type_book',$request->type_book)->first();
        // return $check;
    	if ($check) {
    		$temp	=	Category::where('type_book',$request->type_book)->orderBy('symbol','asc')->select('symbol','name')->get();
    		return response()->json($temp);
    	}
    	else{
    		$temp	=	Category::orderBy('symbol','asc')->select('symbol','name')->get();
    		return response()->json($temp);
    	}
    }
    public function showField($request){
    	$temp	=	Field::where('category',$request->category)->orderBy('symbol','asc')->select('symbol','name')->get();
    	return response()->json($temp);
    }
    public function showProducer($request){
    	$temp	=	Book::query();
    	if ($request->type_book) {
    		$temp->where('type_book',$request->type_book);	
    	}
    	if ($request->category) {
    		$temp->where('category',$request->category);
    	}
    	if ($request->field) {
    		$temp->where('field',$request->field);
    	}
        //lấy toàn bộ ký kiệu nxb sau khi chọn
    	$symbol_producer 	=	$temp->orderBy('producer','asc')->select('producer')->distinct()->get();
        //lấy thông tin nxb
    	$producer 	=	Producer::whereIn('symbol',$symbol_producer)->orderBy('symbol','asc')->select('symbol','name')->get();
    	return response()->json($producer);
    }
}
