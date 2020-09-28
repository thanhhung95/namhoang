<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" >
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li id="show-cart" title="Giỏ hàng">
                <a href="{{route('cart.index')}}"><i style="font-size: 20px;" class="fas fa-shopping-cart"></i>
                    <small id="quantity">
                        {{-- kiem tra xem da dang nhap hay chua neu chua danh nhap de gio hang = 0 --}}                     
                        {{Auth::check()? Cart::session( Auth::user()->id)->getContent()->count() : 0}}
                    </small>
                </a>
            </li>
            @auth
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i style="font-size: 18px;" class="fa fa-user"></i>
                    <span>{{Auth::user()->name}}</span>
                </a>
                <ul class="dropdown-menu">
                    <li> 
                        <a href="{{ route('purchase.index') }}"> Đơn Hàng</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{route('profile.index')}}">Thông tin tài khoản</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ route('logout') }}" ><i class="fa fa-sign-out"></i>Logout</a></li>
                </ul>
            </li>
            @endauth
            @guest
            <li>
                <a href="{{route('login.index')}}"><i class="fa fa-sign-in"></i>Login</a>
            </li>
            @endguest
        </ul>
    </nav>
</div>