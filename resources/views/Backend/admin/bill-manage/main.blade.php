@extends('Layouts.app')
@section('style_link')
@endsection

@section('style_code')
@endsection

@section('content')
	<div class="row">
        <div class="col-sm-10">
            <h3>QUẢN LÝ ĐƠN HÀNG</h3>
        </div>
        <div class="col-sm-2 form-group">
            <select id="status" class="form-control">
                <option value="">--Trạng thái--</option>
                <option value="1">Chưa xử lý</option>
                <option value="2">Đang xử lý</option>
                <option value="3">Đã hoàn thành</option>
            </select>
        </div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered display" style="width: 100%" id="bill-manage-table">
                    <thead>
                        <tr>
                            <th width="5">TT</th>
                            <th width="100">HỌ TÊN</th>
                            <th width="200">ĐỊA CHỈ</th>
                            <th width="100">EMAIL</th>
                            <th width="70">SỐ ĐIỆN THOẠI</th>
                            <th width="70">TỔNG TIỀN</th>
                            <th width="100">THỜI GIAN ĐẶT</th>
                            <th width="70">TRẠNG THÁI</th>
                            <th width="70">#</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
	</div>
@endsection

@section('scripts_link')
@endsection

@section('scripts_code')
	<script>
        $(document).ready(function(){
            table   =   $('#bill-manage-table').DataTable({
                    bSort: false,
                    bInfo: false,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    paging: true,
                    pageLength: 5,
                    responsive: true,
                    info: false,
                    ajax: $.extend({
                            url: 'admin/bill-manage/getDatatable'
                        }, 
                        {
                            type: 'GET'
                        },
                        {
                            data: function (d) {
                                d.status  = $('#status').val() ? $('#status').val() : '';
                            }
                        }),
                    columns: [
                        {
                            data: 'id',
                            render: function (data, type, row, meta) {
                                return meta.row + 1;

                            }
                        },
                        {
                            data: 'name',
                        },
                        {
                            data: 'bill_address',
                            render: function(data, type, row, meta){
                                return data.diachi_chitiet+', '+data.diachi_xa+', '+data.diachi_huyen+', '+data.diachi_tinh
                            }
                        },
                        {
                            data: 'email',
                        },
                        {
                            data: 'phone',
                        },
                        {
                            data: 'total',
                            render: $.fn.dataTable.render.number( ',', '.', 0, )
                        },
                        {
                            data: 'time_bill',
                        },
                        {
                            data: 'status',
                            render: function(data,type,row,meta){
                                if (data == 1) {
                                    return 'Chưa xử lý'
                                }
                                else if (data == 2) {
                                    return 'Đang xử lý'
                                }
                                else if (data == 3) {
                                    return 'Hoàn thành'
                                }
                                else {
                                    return 'Error'
                                }
                            }
                        },
                        {
                            data: 'id',
                            render: function (data, type, row, meta) {
                                return '<div class="btn-group text-justify">'+
                                    '<button data-id=\''+ data+'\' class="bill-detail btn btn-warning btn-sm">'+
                                    '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'+
                                    '</button>'+
                                    '<button data-id=\''+ data+'\' class="del-bill-manage btn btn-danger btn-sm">'+
                                    '<i class="fa fa-trash" aria-hidden="true"></i>'+
                                    '</button>'+
                                '</div>'
                            }
                        }
                    ],
                    columnDefs: [
                        {
                            targets: -1,
                            className: 'dt-body-center'
                        },
                        {
                            targets: 5,
                            className: 'dt-body-right'
                        },
                        {
                            targets: 6,
                            className: 'dt-body-center'
                        }
                    ],
                    language: {
                        search:'Tìm nhanh: ',
                        lengthMenu: 'Hiển thị:  <select class="form-control">'+
                            '<option value="1">1</option>'+
                            '<option value="10">10</option>'+
                            '<option value="20">20</option>'+
                            '<option value="50">50</option>'+
                            '<option value="100">100</option>'+
                            '<option value="500">500</option>'+
                            '<option value="-1">All</option>'+
                            '</select> dòng / trang. ',
                        paginate: {
                            first:    '«',
                            previous: '‹',
                            next:     '›',     
                            last:     '»'
                        },
                        aria: {
                            paginate: {
                                first:    'Trang đầu',
                                previous: 'Trang trước',
                                next:     'Trang sau',
                                last:     'Trang cuối'
                            }
                        }
                    }
                });
            /**********************************************************************
             ============================ Check Status ============================
             **********************************************************************/
             $(document).on('change','#status',function(){
                table.ajax.reload();
             });


            /**********************************************************************
             ============================ Detail Bills ============================
             **********************************************************************/
            $(document).on('click','.bill-detail',function(){
                url = $('base').attr('href')+'admin/bill-manage/';
                id  = $(this).data('id')
                location.href = url+$(this).data('id');
            });
             /**********************************************************************
             ============================ Delete Bill ============================
             **********************************************************************/
            $(document).on('click','.del-bill-manage',function () {
                var url = 'admin/bill-manage/'+$(this).data('id');
                swal({
                    title: "Bạn có muốn xóa không?",
                    text: "Dữ liệu sách sẽ bị xóa vĩnh viễn!",
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
                            url,{
                                type    :   'DELETE',
                                data    :   {
                                    "_token": "{{ csrf_token() }}",
                                },
                                success :   function (data) {
                                    if (data.type == 'success'){
                                        table.ajax.reload();
                                    }
                                    notification(data.type, data.title, data.content);
                                }
                            });
                    }
                });
            });
        });
    </script>
@endsection