<div class="col-sm-12">
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th width="50" scope="col" class="text-center">TT</th>
        <th scope="col" class="text-center">TÊN SÁCH</th>
        <th width="150" scope="col" class="text-center">ĐƠN GIÁ</th>
        <th width="100" scope="col" class="text-center">SỐ LƯỢNG</th>
        <th width="150" scope="col" class="text-center">THÀNH TIỀN</th>
        <th width="50" scope="col" class="text-center">#</th>
      </tr>
    </thead>
    <tbody>
      <?php $stt = 1; ?>
      @foreach($cart as $value)
      <tr>
        <td class="text-center">{{$stt++}}</td>
        <td>{{$value->name}}</td>
        <td class="text-right">{{ number_format($value->price,0) }}</td>
        <td class="text-center">
          <input maxlength="12" type="number" min="0" class="text-center qty-product form-control" data-id="{{$value->id}}" value="{{$value->quantity}}">
        </td>
        <td class="text-right">{{ number_format($value->price*$value->quantity,0) }}</td>
        <td class="text-center">
          <button class="btn btn-custome btn-sm del-product" data-id="{{$value->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <h2 class="text-right m-5">Tổng tiền: <span class="text-danger"> {{number_format($cart_total,0)}} VNĐ</span> </h2>
</div>
<div class="col-sm-12 text-right mt-5 mb-5">
  @if($cart->count() != 0)
  <a href="{{URL('checkout')}}" class="btn btn-custome mb-5">TIẾP TỤC ĐẶT HÀNG <i class="fas fa-arrow-right"></i></a>
  @else
  <button class="btn btn-custome text-right mt-5 mb-5" disabled="">TIẾP TỤC ĐẶT HÀNG <i class="fas fa-arrow-right"></i></button>
  @endif
</div>








