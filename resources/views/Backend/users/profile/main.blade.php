@extends('Layouts.app')
@section('style_link')
@endsection

@section('style_code')
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12 mb-5">
        <h3>THÔNG TIN CÁ NHÂN</h3>
    </div>
    <div class="col-sm-8">
        <form action="#" id="form-user">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Họ và tên:</label>
                <div class="col-sm-10">
                    <input name="name" type="text" class="form-control" value="{{isset($profile->name)? $profile->name: ''}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-10">
                    <input name="email" {{strcmp($profile->provider,'google') ? '':'disabled'}} type="email" class="form-control" value="{{isset($profile->email)? $profile->email: ''}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Số điện thoại:</label>
                <div class="col-sm-10">
                    <input name="phone" {{strcmp($profile->provider,'accountkit') ? '':'disabled'}} type="number" class="form-control" value="{{isset($profile->phone)? $profile->phone: ''}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Địa chỉ:</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" value="{!! !isset($address)?"":(trim($address->diachi_chitiet)!=""?$address->diachi_chitiet.', ':'').$address->diachi_xa.', '.$address->diachi_huyen.','.$address->diachi_tinh !!}" class="form-control" id="txtDiachi" disabled>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary radius-0" data-toggle="modal" data-target="#modal-diadanh"><i class="fas fa-map-marker-alt"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_user" value="{{$profile->id}}">
            <input type="hidden" name="diachi_quocgia" value="{{ isset($address->diachi_quocgia)? $address->diachi_quocgia:""}}">
            <input type="hidden" name="diachi_tinh" value="{{ isset($address->diachi_tinh)? $address->diachi_tinh:""}}">
            <input type="hidden" name="diachi_huyen" value="{{ isset($address->diachi_huyen)? $address->diachi_huyen:""}}">
            <input type="hidden" name="diachi_xa" value="{{ isset($address->diachi_xa)? $address->diachi_xa:""}}">
            <input type="hidden" name="diachi_chitiet" value="{{ isset($address->diachi_chitiet)? $address->diachi_chitiet:""}}">
        </form>
        <button id="save_profile" class="btn btn-primary col-sm-1 float-right">Lưu</button>
    </div>
    <div class="col-sm-4"></div>
</div>
@endsection

@section('scripts_link')
@endsection

@section('scripts_code')
	<script>
        $(document).ready(function(){
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
                    $('#txtDiachi').val((chitiet!=''?chitiet+', ':'')+xa+', '+huyen+', '+tinh);  //chọn xong đẩy vào input
            });

            $(document).on('click','#save_profile',function(){
                var id          =   $('input[name=id_user]').val();
                var formData    =   $('#form-user').serialize();
                swal({
                    title: "Bạn có muốn cập nhập thông tin không!",
                    text: "Thông tin sẽ bị thay đổi",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Có",
                    cancelButtonText: "Không",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function (isConfig) {
                    if (isConfig){
                        $.ajax(
                            'user/profile/'+id,
                            {
                                type    :   'PUT',
                                data    : formData,
                                success :   function (data) {
                                    notification(data.type, data.title, data.content);
                                }
                            });
                    }
                });
            });
        });
    </script>
@endsection