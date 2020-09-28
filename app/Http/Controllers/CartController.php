<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//library
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;
use Response;
use Cart;
//modal
use App\Book;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = Auth::user();
        $cart = Cart::session($user->id)->getContent()->sort();
        $cart_total = Cart::session($user->id)->getSubTotal();
        return view('Backend.cart.main',compact('user','cart','cart_total'));
    }

    public function create(Request $Request)
    {
       

    }

    public function store(Request $request)
    {
        $id_user    = Auth::user()->id;                  //lấy id khách hàng 
        $product    = Book::find($request->id_book);    // lấy thông tin sách

        Cart::session($id_user)->add(array(             // thêm sách vào giỏ hàng của khách hàng
            'id' => $request->id_book,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array()
            ));
        //get count cart
        $quantity = Cart::getContent()->count();       
        return response()->json([
            'quantity'  => $quantity,
            'type'      => 'success',
            'title'     => 'Thành công!',
            'content'   => 'Thêm'.$product->name.'vào giỏ hàng thành công !!']);
        
    }

    public function show(Request $request, $id)  //UPDATE giỏ hàng
    {
        $user       = Auth::user();

        if ($request->Qty == 0 ) {      // nếu bằng 0 thì xóa sản phẩm
            Cart::session($user->id)->remove($request->id_book);
        }
        else{           // khác 0 update sản phẩm mới 
           Cart::session($user->id)->update($request->id_book,array(
                'quantity' => [
                    'relative'  => false,
                    'value'     => $request->Qty,
                ],
            )); 
        }

        $cart       = Cart::session($user->id)->getContent()->sort();
        $cart_total = Cart::session($user->id)->getSubTotal();
        return view('Backend.cart.data',compact('user','cart','cart_total'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user    = Auth::user();
        Cart::session($user->id)->remove($id);

        $cart       = Cart::session($user->id)->getContent()->sort();
        $cart_total = Cart::session($user->id)->getSubTotal();
        return view('Backend.cart.data',compact('user','cart','cart_total'));
    }
}
