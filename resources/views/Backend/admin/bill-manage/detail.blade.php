@extends('Layouts.app')
@section('style_link')
@endsection

@section('style_code')
@endsection

@section('content')
    <div class="row dataTables_wrapper">
        <div class="col-sm-12">
            <h4 class="text-danger">THÔNG TIN KHÁCH HÀNG:</h4>
        </div>
        <div class="col-sm-3">
            <label>Họ và tên:</label>
            <input value="{{isset($get_bill->name)?$get_bill->name:''}}" type="text" class="form-control" disabled>
        </div>
        <div class="col-sm-3">
            <label>Số điện thoại:</label>
            <input value="{{isset($get_bill->phone)?$get_bill->phone:''}}" type="text" class="form-control" disabled>
        </div>
        <div class="col-sm-3">
            <label>Thời gian đặt:</label>
            <input value="{{isset($get_bill->time_bill)?$get_bill->time_bill:''}}" type="text" class="form-control" disabled>
        </div>
        <div class="col-sm-3">
            <label>Trạng thái:</label>
            <select name="status" class="form-control">
                <option {!! isset($get_bill->status)&&$get_bill->status == 1 ?"selected":"" !!} value="1">Chưa xử lý</option>
                <option {!! isset($get_bill->status)&&$get_bill->status == 2 ?"selected":"" !!} value="2">Đang xử lý</option>
                <option {!! isset($get_bill->status)&&$get_bill->status == 3 ?"selected":"" !!} value="3">Hoàn thành</option>
            </select>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12">
                    <label>Email:</label>
                    <input value="{{isset($get_bill->email)?$get_bill->email:''}}" type="text" class="form-control" disabled>
                </div>

                <div class="col-sm-12">
                    <label>Địa chỉ:</label>
                    <input value="{{$get_bill->BillAddress->diachi_chitiet}}, {{$get_bill->BillAddress->diachi_xa}}, {{$get_bill->BillAddress->diachi_huyen}}, {{$get_bill->BillAddress->diachi_tinh}}" type="text" class="form-control" disabled>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <label>Mô tả:</label>
            <textarea rows="4" cols="50" class="form-control" disabled>{{isset($get_bill->description)?$get_bill->description:''}}</textarea>
        </div>
        <input name="id_bill" type="hidden" value="{{$get_bill->id}}">
    </div>
	<div class="row">
        <div class="col-sm-12 mt-5">
            <h4 class="text-danger">CHI TIẾT ĐƠN HÀNG</h4>
        </div>
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover" >
                <thead>
                    <tr align="center">
                        <th width="50">STT</th>
                        <th>Tên sản phẩm</th>
                        
                        <th width="150" class="text-center">Giá(VNĐ)</th>
                        <th width="150" class="text-center">Số lượng </th>
                        <th width="150" class="text-center">Thành tiền(VNĐ) </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0  ?>
                    @foreach($get_bill_detail as $value)   
                    <tr class="odd gradeX">
                        <td>
                            {{$i++}}<br><br>
                        </td>
                        <td>
                            {{$value->book->name}}
                        </td>
                        <td class="text-center">
                            {{ number_format( $value->price ,0) }}
                        </td>
                        <td class="text-center">
                            {{$value->quantity}}
                        </td>
                        <td class="text-center">
                            {{ number_format( $value->price * $value->quantity ,0) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-sm-12 text-right mb-5">
            <h2 class="text-danger m-0">Tổng tiền: {{number_format($get_bill->total,0)}} VNĐ</h2>
        </div>
        <div class="col-sm-12 text-right mb-5">
            {{ $get_bill_detail->links() }}
        </div>
	</div>
@endsection

@section('scripts_link')
@endsection

@section('scripts_code')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','select[name=status]',function(){
            id_bill = $('input[name=id_bill]').val();

            $.ajax('admin/bill-manage/'+id_bill,
            {
                type    :   'PUT',
                data    :  {
                    "_token"    : "{{ csrf_token() }}",
                    'TYPE'      : "STATUS",
                    'id_bill'   : id_bill,
                    'status'    : $(this).val(),
                },
                success :   function (data) { 
                    notification(data.type, data.title, data.content);
                }
            });
        });
    });
</script>
@endsection