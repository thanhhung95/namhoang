<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="{{asset('')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link href="{!! asset('public/css/bootstrap.min.css') !!} " rel="stylesheet">
    <link href="{!! asset('public/font-awesome/css/font-awesome-all.css') !!} " rel="stylesheet">
    <link href="{!! asset('public/font-awesome-4.7.0/css/font-awesome.css') !!} " rel="stylesheet">
    {{-- <link rel="icon" href="namhoang.jpg"> --}}

    @yield('style_link')
    <!--CSS-Datatable -->
    <link href="public/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="public/js/plugins/dataTables4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="public/js/plugins/dataTables4/css/buttons.bootstrap4.min.css">
    {{-- dropzone --}}
    <link rel="stylesheet" href="public/css/plugins/dropzone/dropzone.css">
    <!-- Toastr style -->
    <link href="public/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="{!! asset('public/css/animate.css') !!}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/style.css')}}">
    <!-- Custome -->
    <link rel="stylesheet" href="{{asset('css/hung.css')}}">

    @yield('style_code')
</head>

<body class="skin-1">
    <div class="preloader active"></div>
<!-- Wrapper-->
    <div id="wrapper">
        <!-- Navigation -->
        @include('Layouts.left-nav')
        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">
            <!-- Page wrapper -->
            @include('Layouts.header')
            <!-- Main view  -->
            <div class="wrapper wrapper-content">
                @yield('content')
            </div>  
            <!-- Footer -->
            @include('Layouts.footer')

            {{-- MODAL ĐỊA DANH --}}
            @include('Backend.diadanh.modal-diadanh')
        </div>
        <!-- End page wrapper-->
    </div>
<!-- End wrapper-->
<!-- Mainly scripts -->
<script src="{!! asset('public/js/popper.js') !!}"></script>
<script src="{!! asset('public/js/jquery-3.1.1.min.js') !!}"></script>
<script src="{!! asset('public/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('public/js/plugins/metisMenu/jquery.metisMenu.js') !!}"></script>
<script src="{!! asset('public/js/plugins/slimscroll/jquery.slimscroll.min.js') !!}"></script>


   
   @yield('scripts_link')
    <!--Data-Table -->
    <script src="public/js/plugins/dataTables4/js/jquery.dataTables.min.js"></script>
    <script src="public/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="public/js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="public/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    
    <script src="public/js/plugins/dataTables4/js/dataTables.bootstrap4.min.js"></script>
    <script src="public/js/plugins/dataTables4/js/dataTables.buttons.min.js"></script>
    <script src="public/js/plugins/dataTables4/js/buttons.bootstrap4.min.js"></script>
    <script src="public/js/plugins/dataTables4/js/buttons.html5.min.js"></script>
    <script src="public/js/plugins/dropzone/dropzone.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="{!! asset('public/js/inspinia.js') !!}"></script>
    <script src="{!! asset('public/js/plugins/pace/pace.min.js') !!}"></script>
    <!-- jQuery UI -->
    <script src="{!! asset('public/js/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- Toastr -->
    <script src="{{ asset('public/js/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Dia danh -->
    <script src="{{ asset('js/filter.js')}}"></script>
    <script src="{{ asset('js/diadanh.js')}}"></script>
   
    
    @yield('scripts_code')
    @yield('script-upload')
    <script>
        $(document).ready(function() {
            $( document ).ajaxStart(function() {
                $( '.preloader' ).removeClass('active');
            });
            $(document).ajaxComplete(function (event, xhr, settings) {
                $( '.preloader' ).addClass('active');
                if (xhr.status == 550){
                    notification(xhr.responseJSON.type, xhr.responseJSON.title, xhr.responseJSON.content);
                }
            });
        });

        function notification(type, title, content) {
            title = '';
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                switch (type){
                    case 'success'  : toastr.success(content,title); break;
                    case 'error'    : toastr.error(content,title); break;
                    case 'warning'  : toastr.warning(content,title); break;
                    default         : toastr.warning('Không xác định được thông báo','Cảnh báo!'); break;
                }

            }, 1300);
        }
    </script>

    @if(session('success'))
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000
                    };
                    toastr.success('{!!session('success')!!}','Success');

                }, 1300);

            });
        </script>

    @endif

    @if(session('error'))
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000
                    };
                    toastr.error('{!!session('error')!!}','Lỗi');

                }, 1300);

            });
        </script>

    @endif
    @if(count($errors))
        @foreach($errors->all() as $error)
            <script>
                $(document).ready(function() {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000
                        };
                        toastr.error("{{$error}}", "Lỗi")

                    }, 1300);

                });
            </script>
        @endforeach
    @endif
</body>
</html>