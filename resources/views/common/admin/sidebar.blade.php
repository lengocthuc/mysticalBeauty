<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-center">
                <div class="logo">
                    <a href="{{route('admin-dashboard')}}"><img src="{{asset('img/logo.svg')}}" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item" target="admin">
                    <a href="{{route('admin-dashboard')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item  has-sub" target="products">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Sản Phẩm</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item ">
                            <a href="{{route('admin.products.index')}}">Danh sách</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('products.create')}}">Thêm sản phẩm</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item  has-sub" target="categories">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-collection-fill"></i>
                        <span>Danh Mục</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{route('categories.index')}}">Danh mục lớn</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('subCategories.index')}}">Danh mục con</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('categories.create')}}">Thêm danh mục lớn</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('subCategories.create')}}">Thêm danh mục con</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item  has-sub" target="orders">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Đơn đặt hàng</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item ">
                            <a href="{{route('order.getByStatus',['PENDING'])}}">Đơn chờ xác nhận</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('order.getByStatus',['PROCESSING'])}}">Đơn đang xử lý</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('order.getByStatus',['DELIVERING'])}}">Đơn đang giao</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('order.getByStatus',['CANCELLED'])}}">Đơn đã hủy</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('order.getByStatus',['DELIVERED'])}}">Đơn đã giao</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
