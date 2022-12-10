<div class="wrap">
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex">
                    <button id="primary-nav-button" type="button">Menu</button>
                    <div class="flex-grow-1">
                        <a href="/" class="logo" >
                            <div style="background: url({{asset('img/logo.svg')}});"></div>
                        </a>
                    </div>
                    <nav id="primary-nav" class="dropdown cf flex-grow-1">
                        <ul class="dropdown menu">
                            <li class='active'><a href="{{route('home-page')}}">Trang Chủ</a></li>

                            <li><a href="#">Sản Phẩm</a></li>
                            <li><a href="#">Giới Thiệu</a></li>

                            <li>
                                <a href="#">Danh Mục</a>
                                <ul class="sub-menu">
                                    <li><a href="#">Son Lỳ</a></li>
                                    <li><a href="#">Son Bóng</a></li>
                                    <li><a href="#">Son Dưỡng</a></li>
                                    <li><a href="#">Son Nhũ</a></li>
                                </ul>
                            </li>

                            <li><a href="#">Liên Hệ</a></li>
                            @if(!session()->has('user'))
                                <li class="signing">
                                    <a href="{{route('login')}}">Đăng nhập</a>
                                    <a href="{{route('registration')}}">Đăng ký</a>
                                </li>
                            @else
                                <li><a href="{{route('cart.index')}}" class="cart-link"><i class="fa-solid fa-basket-shopping fs-lg cart"></i></a></li>
                                <li class="d-flex align-items-center">
                                    <p class="my-0">Xin Chào, {{session('user')['name']}}</p>
                                    <a class="" href="{{route('signOut')}}">Đăng Xuất</a>
                                </li>
                            @endif

                        </ul>
                    </nav><!-- / #primary-nav -->
                </div>
            </div>
        </div>
    </header>
</div>
