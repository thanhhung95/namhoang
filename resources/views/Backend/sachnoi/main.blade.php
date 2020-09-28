@extends('Layouts.app')

@section('title')
    {{isset($get_type_book) ? $get_type_book->name : 'NamHoang'}}
@endsection

@section('style_link')
@endsection

@section('style_code')
@endsection

@section('content')
            <div class="row">
                <div class="col-sm-12">
                    @if($errors)
                        @foreach($errors->all() as $message)
                            <p class="text-danger">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="col-sm-6">
                    <h3>{{isset($get_type_book) ? $get_type_book->name : 'Danh Mục Sách Tổng Hợp'}}</h3>
                </div>
                <div class="col-sm-6">
                    <input type="hidden" id="type-book" value="{{ isset($get_type_book)? $get_type_book->symbol: 0}}">       
                    <div class="row filter">
                        <div class="form-group col-sm-4">
                            <select id="category" class="form-control ">
                                <option value="0">--Thể Loại--</option>
                            </select>
                        </div>     
                        <div class="form-group col-sm-4">
                            <select id="field" class="form-control ">
                                <option value="0">--Lĩnh Vực--</option>
                            </select>
                        </div>  
                        <div class="form-group col-sm-4">
                            <select id="producer" class="form-control ">
                                <option value="0">--Nhà Xuất Bản--</option> 
                            </select>
                        </div>  
                    </div>
                    @if(Auth::check() && Auth::user()->lever == 1)
                    <div class="row input">
                        <div class="form-group col-sm-4">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-book">Thêm Sách</button>
                        </div>
                        <div class="form-group col-sm-4">
                            <a href="{{route('export',[isset($get_type_book) ? $get_type_book->symbol : 'GET_ALL','BOOK'])}}" class="btn btn-info btn-sm">Excel <i class="fa fa-file-excel-o"></i></a>
                        </div>
                    </div>
                    @else
                    @endif
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered display" style="width: 100%" id="books-table">
                            <thead>
                                <tr>
                                    <th width="60">Mã Sách</th>
                                    <th width="250">Tên sách</th>
                                    <th width="100">Tác giả</th>
                                    <th width="50">Nhà Xuất Bản</th>
                                    <th width="60">Năm xuất bản</th>
                                    <th width="60">Số trang</th>
                                    <th width="60">Giá(VNĐ)</th>
                                    <th width="70">Chọn mua</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
    <div id="show-modal"></div>
    @include('Backend.sachnoi.form-import')
@endsection

@section('scripts_link')
@endsection

@section('scripts_code')
<script>
    $(document).ready(function(){
        var type_book = $('#type-book').val();

        Table   =   $('#books-table').DataTable({
            bSort: false,
            bInfo: true,
            ordering: true,
            order: [[ 4, "desc" ]],
            processing: true,
            serverSide: true,
            lengthChange: true,
            paging: true,
            pageLength: 10,
            responsive: true,
            info: true,
            resetPaging: false,
            ajax: $.extend({
                url: 'book/getDatatable'
            }, 
            {
                type: 'GET'
            },
            {
                data: function (d) {
                    d.id_type_book  = $('#type-book').val() ? $('#type-book').val() : 0;
                    d.id_field      = $('#field').val() ? $('#field').val() : 0;
                    d.id_category   = $('#category').val() ? $('#category').val() : 0;
                    d.id_producer   = $('#producer').val() ? $('#producer').val() : 0;
                }
            }),
            columns: [
            {
                data: 'book_code',
                render: function (data, type, row, meta) {
                    return data?data:'';
                }
            },
            {
                data: 'name',
            },
            {
                data: 'author',
                render: function(data, type, row, meta){
                    return data?data:'';
                }
            },
            {
                data: 'producer',
                render: function(data, type, row, meta){
                    return data?data.name:'';
                }
            },
            {
                data: 'producer_year',
                render: function(data, type, row, meta){
                    return data?data:'';
                }
            },
            {
                data: 'page',
                render: function(data,type,row,meta){
                    return data?data:'';
                }
            },
            {
                data: 'price',
                render: $.fn.dataTable.render.number( ',', '.', 0, )
            },
            {
                data: 'id',
                render: function (data, type, row, meta) {
                    return '<div class="btn-group text-justify">'+
                    @if (Auth::check() && Auth::user()->lever == 2) 
                    '<button data-id=\''+ row.id+'\' class="add-cart btn btn-custome btn-sm"><i class="fa fa-cart-plus"></i></button>'+
                    @elseif(Auth::check() && Auth::user()->lever == 1 )
                    '<button data-row=\''+JSON.stringify(row)+'\' class="edit-book btn btn-warning btn-sm">'+
                    '<i class="fa fa-pencil-square-o"></i>'+
                    '</button>'+
                    '<button data-id=\''+ data+'\' class="del-book btn btn-danger btn-sm">'+
                    '<i class="fa fa-trash"></i>'+
                    '</button>'+
                    @else
                    '<a href="{{route('login.index')}}" class="btn btn-custome btn-sm"><i class="fa fa-cart-plus"></i></a>'+
                    @endif
                    '</div>'
                }
            }
            ],
            columnDefs: [
            {
                targets: [0,-1,4,5,7],
                className: 'dt-body-center'
            },
            {
                targets: 6,
                className: 'dt-body-right'
            }
            ],
            language: {
                search:'Tìm kiếm: ',
                lengthMenu: 'Hiển thị:  <select class="form-control">'+
                '<option value="5">5</option>'+
                '<option value="10">10</option>'+
                '<option value="20">20</option>'+
                '<option value="50">50</option>'+
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
                },
                info: "Từ _START_ tới _END_ của _TOTAL_ cuốn",
            }
        });
        /**********************************************************************
         ============================ Filter ============================
         **********************************************************************/
        $(document).on('change','.filter select',function(){
            Table.ajax.reload();
        });
         /**********************************************************************
         ============================ ADD TO CART ============================
         **********************************************************************/
        $(document).on('click','.add-cart',function(){
            CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax(
                'cart',
                {
                    type    : "POST",
                    data    : {
                        _token      :   CSRF_TOKEN,
                        action      :   'ADD_TO_CART',
                        id_book     :   $(this).data('id'),
                    },
                    success  :function(data){
                        notification(data.type, data.title, data.content);
                        $('#quantity').html(data.quantity);
                    }
                })
        });
         /**********************************************************************
         ============================ Add And Edit Book ============================
         **********************************************************************/
        $(document).on('click','#save-book',function () {
            var formData    =   $('#post-form').serialize();
            var id          =   $('input[name=id]').val();
            $.ajax(
                '/book/'+id,
                {
                    type    :   'PUT',
                    data    :   formData,
                    success :   function (data) {
                        $('#modal-book').modal('hide');
                        Table.ajax.reload(null,false);
                        notification(data.type, data.title, data.content);
                    }
                });
        });
         /**********************************************************************
         ============================ Delete Book ============================
         **********************************************************************/
         $(document).on('click','.del-book',function () {
            var url = '/book/'+$(this).data('id');
            swal({
                title: "Bạn có muốn xóa không?",
                text: "Dữ liệu sách sẽ bị xóa vĩnh viễn!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ea0026",
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
         ============================ Edit Book ============================
         **********************************************************************/
         $(document).on('click','.edit-book',function(){
            data = $(this).data('row');
            $.ajax(
                '/book/getFormEdit',
                {
                    type: 'GET',
                    success: function(e){
                        $('#show-modal').html(e);
                        $('#modal-book').modal('show');
                       
                        $('input[name=book_code]').val(data.book_code);
                        $('select[name=type_book]').val(data.type_book);
                        $('select[name=status]').val(data.status);
                        $('select[name=field]').val(data.field.symbol);
                        $('select[name=category]').val(data.category.symbol);
                        $('input[name=name]').val(data.name);
                        $('input[name=author]').val(data.author);
                        $('select[name=producer]').val(data.producer.symbol);
                        $('input[name=producer_year]').val(data.producer_year);
                        $('input[name=page]').val(data.page);
                        $('input[name=size]').val(data.size);
                        $('input[name=print]').val(data.print);
                        $('input[name=price]').val(data.price);
                        $('input[name=id]').val(data.id);
                    }
                }
            );
        });
        /**********************************************************************
         ============================ RESET FORM ============================
         **********************************************************************/
        function reset(){
            $('form').trigger("reset");
            $('input[name=book_code]').prop('disabled', false);
            $('input[name=id]').val(0);
        }
    });
</script>

@endsection

