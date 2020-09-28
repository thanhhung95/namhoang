@extends('Layouts.app')

@section('style_link')
    
@endsection

@section('style_code')
   
@endsection

@section('content')
<div class="row pt-5 pb-5" style="background: #fff">
    <div class="col-sm-7">  
        <div class="form-group">
            <h3 class="text-danger">GIỎ HÀNG CỦA BẠN</h3>
        </div>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th width="50" scope="col" class="text-center">TT</th>
                    <th scope="col" class="text-center">TÊN SÁCH</th>
                    <th width="90" scope="col" class="text-center">ĐƠN GIÁ</th>
                    <th width="90" scope="col" class="text-center">SỐ LƯỢNG</th>
                    <th width="100" scope="col" class="text-center">THÀNH TIỀN</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; ?>
                @foreach(Cart::session( Auth::user()->id)->getContent()->sort() as $value => $data)
                <tr>
                    <td class="text-center">{{$stt++}}</td>
                    <td>{{$data->name}}</td>
                    <td class="text-right">{{ number_format($data->price,0) }}</td>
                    <td>
                    <input disabled  maxlength="12" type="number" min="1" class="text-center qty-product form-control" data-id="{{$data->id}}" value="{{$data->quantity}}">
                    </td>
                    <td class="text-right">{{ number_format($data->price*$data->quantity,0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h2 class="text-right m-5">Tổng tiền: <span class="text-danger"> {{number_format(Cart::session( Auth::user()->id)->getSubTotal(),0)}} VNĐ</span> </h2>
    </div>
    <div class="col-sm-5 border-left">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="text-danger">THANH TOÁN VẬN CHUYỂN</h3>
            </div>
            <div class="col-sm-12">
                @if(Session::has('BillError'))
                    @component('Backend.alert')
                        @slot('class')
                            alert-warning
                        @endslot
                        @slot('title')
                            {{Session::get('BillError')}}
                        @endslot
                    @endcomponent
                @endif
            </div>
            <form action="{{route('checkout.store')}}" method="POST" role="form">
                {{csrf_field()}}
                <div class="col-sm-12 form-group">
                    <label class="required">Họ và tên:</label>
                    <input name="name" type="text" class="form-control" value="{{isset($profile->name)? $profile->name: ''}}">
                </div>
                <div class="col-sm-12 form-group">
                    <label class="required">Địa chỉ nhận hàng: </label>
                    <div class="input-group">
                        <input type="text" value="{!! !isset($address)?"":(trim($address->diachi_chitiet)!=""?$address->diachi_chitiet.', ':'').$address->diachi_xa.', '.$address->diachi_huyen.', '.$address->diachi_tinh !!}" class="form-control" id="txtNoio" disabled>
                        <span class="input-group-btn">
                            <button type="button" id="btn-address" class="btn btn-primary radius-0" data-toggle="modal" data-target="#modal-diadanh"><i class="fas fa-map-marker-alt"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-sm-4 form-group">
                    <label class="required">Điện thoại:</label>
                    <input name="phone" type="text" class="form-control" value="{{isset($profile->phone)? $profile->phone: ''}}">
                </div>
                <div class="col-sm-8 form-group">
                    <label class="required">Email:</label>
                    <input name="email" type="text" class="form-control" value="{{isset($profile->email)? $profile->email: ''}}">
                </div>
                <div class="col-sm-12 form-group">
                    <label>Chú thích:</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-sm-12">
                    <h2 class=" text-right">Tổng tiền: <span class="text-danger">{{number_format(Cart::session( Auth::user()->id)->getSubTotal(),0)}} ₫</span></h2>
                </div>
                <div class="col-sm-6 col-sm-offset-3 mt-3 mb-5">
                    <button id="order" type="submit" class="btn btn-custome btn-lg btn-block">Đặt Hàng</button>
                </div>
                <!-- hide input -->
                <input type="hidden" name="id_user" value="{{isset(Auth()->user()->id) ? Auth()->user()->id : ''}}">
                <!-- Địa chỉ  -->
                <input type="hidden" name="diachi_quocgia" value="{!! isset($address->diachi_quocgia)?$address->diachi_quocgia:'' !!}">
                <input type="hidden" name="diachi_tinh" value="{!! isset($address->diachi_tinh)?$address->diachi_tinh:'' !!}">
                <input type="hidden" name="diachi_huyen" value="{!! isset($address->diachi_huyen)?$address->diachi_huyen:'' !!}">
                <input type="hidden" name="diachi_xa" value="{!! isset($address->diachi_xa)?$address->diachi_xa:'' !!}">
                <input type="hidden" name="diachi_chitiet" value="{!! isset($address->diachi_chitiet)?$address->diachi_chitiet:'' !!}">
                {{--  --}}
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts_link')

@endsection

@section('scripts_code')
    <script type="text/javascript">
        // Update Địa chỉ (địa danh)
        /**
         *
         *  Xử lý khi nhấn nút chọn từ modal địa danh #btn_modal_chondiadanh là nút ở trong modal
         *
         **/
        $(document).on('click','#btn_modal_chondiadanh',function () {
            //lấy toàn bộ dữ liệu từ bảng địa danh sau khi chọn
            var diadanh_type = $('input[name=dinhdanh_type]').val(),
                quocgia = $('select[name=quocgia] :selected').text(),
                tinh    = $('select[name=tinh] :selected').text(),
                huyen   = $('select[name=huyen] :selected').text(),
                xa      = $('select[name=xa] :selected').text(),
                chitiet = $('textarea[name=chitiet]').val();

                $('input[name=diachi_quocgia]').val(quocgia);
                $('input[name=diachi_tinh]').val(tinh);
                $('input[name=diachi_huyen]').val(huyen);
                $('input[name=diachi_xa]').val(xa);
                $('input[name=diachi_chitiet]').val(chitiet);
                $('#txtNoio').val((chitiet!=''?chitiet+', ':'')+xa+', '+huyen+', '+tinh);  //chọn xong đẩy vào input
            
            $('#modal-diadanh').hide();
        });
    </script>
@endsection

