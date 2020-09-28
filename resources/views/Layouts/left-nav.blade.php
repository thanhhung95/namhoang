{{-- Lấy toàn bộ danh sách loại sách--}}
<?php 
    $type_book   =   \App\TypeBook::where('status','=',1)->orderBy('id','asc')->get();
?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a href="{{route('profile.index')}}">
                        <img style="width:50px;height:50px;" alt="image" class="img-circle" src="{{isset(Auth::user()->avatar)? Auth::user()->avatar: 'public/img/profile_small.jpg'}}" />
                    </a>
                    <span class="clear"> 
                        @auth
                        <span>
                            {{isset(Auth::user()->name)? Auth::user()->name:"BẠN CHƯA TẠO TÊN" }}
                        </span></br>
                        <span>
                            {{Auth::user()->lever == 1 ? '(ADMIN)': '(Khách Hàng)'}}
                        </span>
                        @else
                        <span>Bạn chưa đăng nhập</span>
                        @endauth
                    </span> 
                </div>
                <div class="logo-element">
                    NH
                </div>
            </li>
            <li>
                <p><i class="fa fa-th-large"></i> <span class="nav-label">THÔNG TIN DANH MỤC SÁCH</span></p>
            </li>
            <li class="space-line"></li>
            <li class="mb-3 {{strcmp(\Request::url(),route('index')) ? '' : 'active'}}">
                <a href="{{route('index')}}"><i class="fa fa-book"></i><span class="nav-label">SÁCH TỔNG HỢP</span></a>
            </li>
            @foreach($type_book as $data)
            <li class="mb-3 {{strcmp(\Request::url(),route('book.show',$data->symbol)) ? '' : 'active'}}">
                <a href="{{route('book.show',$data->symbol)}}">
                    <i class="fa fa-book"></i>
                    <span class="nav-label">{{$data->name}}</span>
                </a>
            </li>
            @endforeach
            {{-- ADMIN --}}
            
            {{--Menu User--}}
            @if(Auth::check() && Auth::user()->lever == 1)
            <li class="mb-3 {{strcmp(\Request::url(),route('user-manage.index')) ? '' : 'active'}}">
                <a href="{{route('user-manage.index')}}">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-label">Quản lý User</span>
                </a>
            </li>
            {{--Menu Lĩnh vực--}}
            <li class="mb-3 {{strcmp(\Request::url(),route('field-manage.index')) ? '' : 'active'}}">
                <a href="{{route('field-manage.index')}}">
                    <i class="fa fa-cubes" aria-hidden="true"></i>
                    <span class="nav-label">Quản lý lĩnh vực</span>
                </a>
            </li>
            {{--Menu Thể loại--}}
            <li class="mb-3 {{strcmp(\Request::url(),route('category-manage.index')) ? '' : 'active'}}">
                <a href="{{route('category-manage.index')}}">
                    <i class="fa fa-cube" aria-hidden="true"></i>
                    <span class="nav-label">Quản lý thể loại</span>
                </a>
            </li>
            {{--Menu Loại sách--}}
            <li class="mb-3 {{strcmp(\Request::url(),route('typebook-manage.index')) ? '' : 'active'}}">
                <a href="{{route('typebook-manage.index')}}">
                    <i class="fa fa-database" aria-hidden="true"></i>
                    <span class="nav-label">Quản lý loại sách</span>
                </a>
            </li>
            {{--Menu đơn hàng--}}
            <li class="mb-3 {{strcmp(\Request::url(),route('bill-manage.index')) ? '' : 'active'}}">
                <a href="{{route('bill-manage.index')}}">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <span class="nav-label">Quản lý đơn hàng</span>
                </a>
            </li>
            {{--Menu NXB--}}
            <li class="mb-3 {{strcmp(\Request::url(),route('producer-manage.index')) ? '' : 'active'}}">
                <a href="{{route('producer-manage.index')}}">
                    <i class="fa fa-address-book" aria-hidden="true"></i>
                    <span class="nav-label">Quản lý nhà xuất bản</span>
                </a>
            </li>
            @endif
            {{-- END ADMIN --}}
        </ul>
    </div>
</nav>