@extends('Layouts.app')
@section('style_link')
@endsection

@section('style_code')
@endsection

@section('content')
	<div class="row">
        <div class="col-sm-12">
            <h3>QUẢN LÝ LĨNH VỰC</h3>
        </div>
        <div class="col-sm-4">
            <div class="row table-bordered dataTables_wrapper">
                <form id="post-form-field">
                    @csrf
                    <div class="col-sm-12 form-group">
                        <label>Tên:</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Ký hiệu:</label>
                        <input type="text" name="symbol" class="form-control">
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Thể loại</label>
                        <select name="category" class="form-control">
                            <option value="">--Chọn--</option>
                            @foreach($category as $value)
                            <option value="{{$value->symbol}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input name="id" type="hidden" value="">
                </form>
                <div class="col-sm-12">
                    <button id="save-field" class="btn btn-primary btn-sm float-right mt-5 mb-5">Lưu</button>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="table-responsive">
                <table class="table table-bordered display" style="width: 100%" id="field-manage-table">
                    <thead>
                        <tr>
                            <th width="5">TT</th>
                            <th width="100">THỂ LOẠI</th>
                            <th width="100">KÝ HIỆU</th>
                            <th>TÊN</th>
                            <th width="60">#</th>
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
            Table   =   $('#field-manage-table').DataTable({
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
                    ajax: 'admin/field-manage/getDatatable',
                    columns: [
                        {
                            data: 'id',
                            render: function (data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'category',
                            render: function (data, type, row, meta) {
                                return data.name;
                            }
                        },
                        {
                            data: 'symbol',
                        },
                        {
                            data: 'name',
                        },
                        {
                            data: 'id',
                            render: function (data, type, row, meta) {
                                return '<div class="btn-group text-justify">'+
                                    '<button data-row=\''+JSON.stringify(row)+'\' class="edit-field btn btn-warning btn-sm">'+
                                    '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'+
                                    '</button>'+
                                    '<button data-id=\''+ data+'\' class="del-field btn btn-danger btn-sm">'+
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
             ============================ Add - Edit- field ============================
             **********************************************************************/
            $('#save-field').on('click',function () {
                var formData    =   $('#post-form-field').serialize();
                var id          =   $('input[name=id]').val();
                if (id == 0) {
                    var type    =   'POST';
                    var url     =   'admin/field-manage';
                }
                else{
                    var type    =   'PUT';
                    var url     =   'admin/field-manage/'+id;
                }
                $.ajax(url,{
                    type    :   type,
                    data    :   formData,
                    success :   function (data) { 
                        if (data.type == 'success'){
                            reset();
                            Table.ajax.reload();
                        }
                        notification(data.type, data.title, data.content);
                    }
                });
            });
             /**********************************************************************
             ============================ Delete Book ============================
             **********************************************************************/
            $(document).on('click','.del-field',function () {
                var url = 'admin/field-manage/'+$(this).data('id');
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
                                        Table.ajax.reload();
                                    }
                                    notification(data.type, data.title, data.content);
                                }
                            });
                    }
                });
            });
             /**********************************************************************
             ============================ Edit Book ============================
             **********************************************************************/
            $(document).on('click','.edit-field',function(){
                data = $(this).data('row');
                $('select[name=category]').val(data.category.symbol);
                $('input[name=name]').val(data.name);
                $('input[name=symbol]').val(data.symbol);
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