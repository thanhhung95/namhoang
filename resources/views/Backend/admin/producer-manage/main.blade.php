@extends('Layouts.app')
@section('style_link')
@endsection

@section('style_code')
@endsection

@section('content')
<div class="row">
    <div class="col-sm-8">
        <h3>QUẢN LÝ NHÀ XUẤT BẢN</h3>
    </div>
    <div class="col-sm-4">
        <button data-toggle="modal" data-target="#modal-form-producer" class="btn btn-sm btn-primary float-right mb-5"><i class="fa fa-plus" aria-hidden="true"></i> Thêm</button>
    </div>
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered display" style="width: 100%" id="producer-table">
                <thead>
                    <tr>
                        <th width="5">TT</th>
                        <th>TÊN</th>
                        <th width="150">KÝ HIỆU</th>
                        <th width="100">WEBSITE</th>
                        <th width="70">PHONE</th>
                        <th width="70">EMAIL</th>
                        <th width="50">#</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
    {{-- Modal Form producer --}}
    @include('Backend.admin.producer-manage.form')
@endsection

@section('scripts_link')
@endsection

@section('scripts_code')
	<script>
        $(document).ready(function(){
            Table   =   $('#producer-table').DataTable({
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
                            url: 'admin/producer-manage/getDatatable'
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
                            data: 'name',
                        },
                        {
                            data: 'symbol',
                        },
                        {
                            data: 'website',
                        },
                        {
                            data: 'phone',
                        },
                        {
                            data: 'email',
                        },
                        {
                            data: 'id',
                            render: function (data, type, row, meta) {
                                return '<div class="btn-group text-justify">'+
                                    '<button data-row=\''+JSON.stringify(row)+'\' class="edit-producer btn btn-warning btn-sm">'+
                                    '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'+
                                    '</button>'+
                                    '<button data-id=\''+ data+'\' class="del-producer btn btn-danger btn-sm">'+
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
             ============================ Add - Edit- producer ============================
             **********************************************************************/
            $('#save-producer').on('click',function () {
                var formData    =   $('#post-form-producer').serialize();
                var id          =   $('input[name=id]').val();
                if (id == 0) {
                    var type    =   'POST';
                    var url     =   'admin/producer-manage';
                }
                else{
                    var type    =   'PUT';
                    var url     =   'admin/producer-manage/'+id;
                }
                $.ajax(url,{
                    type    :   type,
                    data    :   formData,
                    success :   function (data) { 
                        if (data.type == 'success'){
                            reset();
                            $('#modal-form-producer').modal('hide');
                            Table.ajax.reload(null,false);
                        }
                        notification(data.type, data.title, data.content);
                    }
                });
            });
             /**********************************************************************
             ============================ Delete Producer ============================
             **********************************************************************/
            $(document).on('click','.del-producer',function () {
                var url = 'admin/producer-manage/'+$(this).data('id');
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
                                        Table.ajax.reload(null,false);
                                    }
                                    notification(data.type, data.title, data.content);
                                }
                            });
                    }
                });
            });
             /**********************************************************************
             ============================ Edit Producer ============================
             **********************************************************************/
            $(document).on('click','.edit-producer',function(){
                data = $(this).data('row');
                temp = $('#modal-form-producer').modal('show');

                $('input[name=name]').val(data.name);
                $('input[name=symbol]').val(data.symbol);
                $('input[name=website]').val(data.website);
                $('input[name=phone]').val(data.phone);
                $('input[name=email]').val(data.email);
                $('input[name=address]').val(data.address);
                $('input[name=id]').val(data.id);
            });
            /**********************************************************************
             ============================ RESET FORM ============================
             **********************************************************************/
            function reset(){
                $('form').trigger("reset");
                $('input[name=id]').val(0);
            }
        });
    </script>
@endsection