@extends('Layouts.app')
@section('style_link')
@endsection

@section('style_code')
@endsection

@section('content')
	<div class="row">
        <div class="col-sm-8">
            <h3>DANH SÁCH USERS</h3>
        </div>
        <div class="col-sm-4">
            <button id="add-user" class="btn btn-sm btn-primary float-right mb-5"><i class="fa fa-plus" aria-hidden="true"></i> Thêm</button>
        </div>
        <div class="col-sm-12 table-responsive">
            <table class="table table-bordered display" style="width: 100%" id="user-manage-table">
                <thead>
                    <tr>
                        <th width="5">TT</th>
                        <th width="200">Email</th>
                        <th width="100">Họ và tên</th>
                        <th width="50">Số điện thoại</th>
                        <th width="100">Địa chỉ</th>
                        <th width="60">Dịch vụ</th>
                        <th width="40">Lever</th>
                        <th width="50">Trạng thái</th>
                        <th width="50">#</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="show-modal"></div>
@endsection

@section('scripts_link')
@endsection

@section('scripts_code')
	<script>
        $(document).ready(function(){
            Table   =   $('#user-manage-table').DataTable({
                    bSort: false,
                    bInfo: false,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    paging: true,
                    pageLength: 10,
                    responsive: true,
                    info: false,
                    ajax: $.extend({
                            url: 'admin/user-manage/getDatatable'
                        }, 
                        {
                            type: 'GET'
                        },
                        {
                            data: function (d) {
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
                            data: 'email',
                        },
                        {
                            data: 'name',
                        },
                        {
                            data: 'phone',
                        },
                        {
                            data: 'user_address',
                            render: function(data, type, row, meta){
                                if (data == null) {
                                    return '';
                                }
                                else{
                                    return data.diachi_chitiet+' , '+data.diachi_xa+' , '+data.diachi_huyen+' , '+data.diachi_tinh;
                                }
                            }
                        },
                        {
                            data: 'provider',
                        },
                        {
                            data: 'lever',
                            render: function(data, type, row, meta){
                            	if (data == 1) {
                            		return 'Admin'
                            	}
                            	else{
                            		return 'Khách'
                            	}
                            }
                        },
                        {
                            data: 'status',
                            render: function(data, type, row, meta){
                            	if (data == 1) {
                            		return 'Hoạt động'
                            	}
                            	else{
                            		return 'Dừng'
                            	}
                            }
                        },
                        {
                            data: 'id',
                            render: function (data, type, row, meta) {
                                return '<div class="btn-group text-justify">'+
                                    '<button data-row=\''+JSON.stringify(row)+'\' class="edit-user btn btn-warning btn-sm">'+
                                    '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'+
                                    '</button>'+
                                    '<button data-id=\''+ data+'\' class="del-user btn btn-danger btn-sm">'+
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
             ============================ Show Modal Form ============================
             **********************************************************************/
            $(document).on('click','#add-user',function(){
                $.ajax('admin/user-manage/getFormUser',
                    {
                    type    :   'GET',
                    success :   function (data) {
                        $('#show-modal').html(data);
                        $('#modal-form-user').modal('show')
                    }
                });
            });
            /**********************************************************************
             ============================ Show Modal Edit ============================
             **********************************************************************/
            $(document).on('click','.edit-user',function(){
                data_user = $(this).data('row');
                address_user = data_user.user_address

                $.ajax('admin/user-manage/getEditUser',
                    {
                    type    :   'GET',
                    success :   function (data) {
                        $('#show-modal').html(data);
                        $('#modal-edit-user').modal('show')

                        $(document).find('input[name=name]').val(data_user.name);
                        $(document).find('input[name=phone]').val(data_user.phone);
                        $(document).find('input[name=email]').val(data_user.email);
                        $(document).find('#txtNoio').val((address_user)? address_user.diachi_chitiet+', '+address_user.diachi_xa+', '+address_user.diachi_huyen+', '+address_user.diachi_tinh :'');
                        $(document).find('select[name=lever]').val(data_user.lever);
                        $(document).find('select[name=status]').val(data_user.status);
                        $(document).find('input[name=id]').val(data_user.id);

                        $(document).find('input[name=diachi_quocgia]').val((address_user)? address_user.diachi_quocgia:'');
                        $(document).find('input[name=diachi_tinh]').val((address_user)? address_user.diachi_tinh:'');
                        $(document).find('input[name=diachi_huyen]').val((address_user)? address_user.diachi_huyen:'');
                        $(document).find('input[name=diachi_xa]').val((address_user)? address_user.diachi_xa:'');
                        $(document).find('input[name=diachi_chitiet]').val((address_user)? address_user.diachi_chitiet:'');
                    }
                });
            });
            /**********************************************************************
             ============================ Add-user ============================
             **********************************************************************/
            $(document).on('click','#save-user',function(){
                var formData    =   $('#post-form').serialize();
                var type        =   'POST';
                var url         =   'admin/user-manage';
                $.ajax(url,{
                    type    :   type,
                    data    :   formData,
                    success :   function (data) {
                        if (data.type == 'success'){
                            $('#modal-form-user').modal('hide');
                            reset();
                            Table.ajax.reload(null,false);
                        }
                        notification(data.type, data.title, data.content);
                    }
                });
            });
             /**********************************************************************
             ============================ Edit Info User ============================
             **********************************************************************/
            $(document).on('click','#save-info',function () {
                var formData    =   $('#post-form-info').serialize();
                var id          =   $('input[name=id]').val();
                var type    =   'PUT';
                var url     =   'admin/user-manage/'+id;
                $.ajax(url,{
                    type    :   type,
                    data    :   formData,
                    success :   function (data) {
                        if (data.type == 'success'){
                            $('#modal-edit-user').modal('hide');
                            reset();
                            Table.ajax.reload(null,false);
                        }
                        notification(data.type, data.title, data.content);
                    }
                });
            });
            /**********************************************************************
             ============================ Edit Password User ============================
             **********************************************************************/
            $('#save-password').on('click',function () {
                var formData    =   $('#post-form-password').serialize();
                var id          =   $('input[name=id]').val();
                var type    =   'PUT';
                var url     =   'admin/user-manage/'+id;
                $.ajax(url,{
                    type    :   type,
                    data    :   formData,
                    success :   function (data) { 
                        if (data.type == 'success'){
                            $('#modal-edit-user').modal('hide');
                            reset();
                            Table.ajax.reload(null,false);
                        }
                        notification(data.type, data.title, data.content);
                    }
                });
            });
             /**********************************************************************
             ============================ Delete User ============================
             **********************************************************************/
            $(document).on('click','.del-user',function () {
                var url = 'admin/user-manage/'+$(this).data('id');
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
                            url,
                            {
                                type    :   'DELETE',
                                data    :   {
                                    "_token": "{{ csrf_token() }}",
                                },
                                success :   function (data) {
                                    if (data.type == 'success'){
                                        Table.ajax.reload(null,false);
                                    }
                                    notification(data.type, data.title, data.content);
                                }
                            }); 
                    }
                });
            });
            /**********************************************************************
             ============================ RESET FORM ============================
             **********************************************************************/
            function reset(){
                $('form').trigger("reset");
                $('input[name=id]').val(0);
            }
            /**********************************************************************
             ============================ GET DIA DANH ============================
             **********************************************************************/
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

        });
    </script>
@endsection