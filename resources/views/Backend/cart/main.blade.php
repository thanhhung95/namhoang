@extends('Layouts.app')

@section('style_link')
    
@endsection

@section('style_code')
   
@endsection

@section('content')
<div class="row mb-5">
  <div class="col-sm-8">
    <h3 class="text-danger">GIỎ HÀNG CỦA BẠN</h3>
  </div>
  <div class="col-sm-4 text-right">
    <a href="{{route('export',[Auth::user()->id,'CART'])}}" class="btn btn-info btn-sm">Excel <i class="fa fa-file-excel-o"></i></a>
  </div>
</div>
<div class="row" id="data-cart">
  @include('Backend.cart.data',[
    'cart'       =>$cart,
    'cart_total' =>$cart_total,
    ])
</div>
@endsection

@section('scripts_link')
@endsection

@section('scripts_code')
<script type="text/javascript">
$(document).ready(function(){
//update giỏ hàng
  $(document).on('change','.qty-product',function(){
    $.ajax(
      'cart/'+$(this).val(),
      {
        type    : 'GET',
        data    : {
          id_book : $(this).data('id'),
          Qty     : $(this).val(),
        },
        success : function(data){
          $('#data-cart').html(data);
        }
      }
      )
  });
//Xóa giỏ hàng
  $(document).on('click','.del-product',function(){
    CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax(
      'cart/'+$(this).data('id'),
      {
        type    : 'DELETE',
        data    : {
          _token  : CSRF_TOKEN,
        },
        success : function(data){
          $('#data-cart').html(data);
        }
      })
  });
});
</script>

@endsection

