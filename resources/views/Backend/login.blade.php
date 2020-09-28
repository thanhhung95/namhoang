<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">
<base href="{{asset('')}}">
<meta name="description" content="">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Lucid Bootstrap 4.1.1 Admin Template">
<meta name="author" content="WrapTheme, design by: ThemeMakker.com">
<link rel="icon" href="namhoang.jpg">
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
<!-- MAIN CSS -->
<link rel="stylesheet" href="{{asset('css/main.css')}}">
<link rel="stylesheet" href="{{asset('css/color_skins.css')}}">
<!--CSS-PLUGIN -->
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/bootstrapSocial/bootstrap-social.css')}}">
<style type="text/css">
    
    .btn-social{
        padding-left: 37px;
        overflow: unset; 
    }
    .form-btn-login{
        display: table;
        width: 100%;
    }
    .btn-login{
        width: 33%;
        display: table-cell;
        padding:0 5px;
    }
    .btn-login:last-child{
        padding-right: 0;
    }
    .btn-login:first-child{
        padding-left: 0;
    }
    .btn-social{
        width: 100%;
        text-align: center;
    }
    .btn-success{
        background-color: rgb(17, 181, 12);
    }
    .alert{
        margin-top: 15px !important;
        margin-bottom: 0px !important;
    }
    @media screen and (max-width: 480px) {
        .btn-login{
            width: 100%;
            display: block;
            padding: 0;
            text-align: center;
        }
    }
</style>
</head>
<body class="theme-orange">
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="top">
{{--                         <img src="../images/logo.png" alt="Lucid">  --}}
                    </div>
                    <div class="card">
                        <div class="header">
                            <p class="lead">Login to your account</p>
                            @if(Session::has('loginFail'))
                                @component('Backend.alert')
                                    @slot('class')
                                        alert-danger
                                    @endslot
                                    @slot('title')
                                        {{Session::get('loginFail')}}
                                    @endslot
                                @endcomponent
                            @elseif(Session::has('noConfirm'))
                                @component('Backend.alert')
                                    @slot('class')
                                        alert-warning
                                    @endslot
                                    @slot('title')
                                    {{Session::get('noConfirm')}}
                                    @endslot
                                @endcomponent
                            @endif
                        </div>
                        <div class="body">
                            <form class="form-auth-small" action="{{url('login')}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Email</label>
                                    <input type="email" name="email" class="form-control" id="signin-email" value="" placeholder="Email" required requiredmsg="Bạn chưa điền tài khoản">
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Password</label>
                                    <input type="password" name="password" class="form-control" id="signin-password" value="" placeholder="Password" required requiredmsg="Bạn chưa điền mật khẩu">
                                </div>
                                {{-- <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox" value="checked" name="checked">
                                        <span>Remember me</span>
                                    </label>                                
                                </div> --}}
                                <button type="submit" class="btn btn-primary btn-lg btn-block">ĐĂNG NHẬP</button>
                                <div class="form-btn-login">
                                    <div class="btn-login">
                                        <!-- Button-LOGIN-GOOGLE -->
                                        <a class="btn btn-social btn-google" href="{{url('google/redirect')}}">
                                            <i class="fa fa-google"></i>Google
                                        </a>
                                    </div>  
                                    <div class="btn-login">
                                        <!-- Button-LOGIN-FACEBOOK -->
                                        <a class="btn btn-social btn-facebook" href="{{url('facebook/redirect')}}">
                                            <i class="fa fa-facebook"></i>Facebook
                                        </a>
                                    </div>
                                    {{-- <div class="btn-login">
                                        <!-- AccounnKit - Facebook -->
                                        <button class="btn btn-social btn-success btn-accountkit" type="button" >
                                            <i class="fa fa-commenting-o"></i>
                                        SMS
                                        </button>
                                    </div> --}}
                                </div>  
                                <div class="bottom">
                                    <span>Copyright Desgin by Mr.Hung © 2019</span>
                                    {{-- <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="page-forgot-password.html">Forgot password?</a></span>
                                    <span>Don't have an account? <a href="page-register.html">Register</a></span> --}}
                                </div>
                            </form>
                            <!-- Form CALL BACK accountKit -->
                            <form action="accountkit/callback" method="post" id="form">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="code" id="code" />
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- AccountKit JS -->
    <script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
    <script src="{{asset('js/ack.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click','.btn-accountkit',function(){
                smsLogin();
            });
        });
    </script>
</body>
</html>



