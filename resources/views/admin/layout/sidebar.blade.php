<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <img src="{{ asset('admin/images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ asset('admin/images/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
    </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
        <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
        </button>
        </div>
    </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item">
        <a href="/admin/dashboard" class="nav-link {{ $active == 'dashboard' ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
            Dashboard
            </p>
        </a>
        
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-user"></i>
                <p>User</p>
                <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/admin/users" class="nav-link {{ $active == 'users' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ $active == 'users' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create User</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>
            Product
            <i class="fas fa-angle-left right"></i>
            <span class="badge badge-info right">6</span>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="/admin/products" class="nav-link {{ $active == 'products' ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Product</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="/admin/products/create" class="nav-link {{ $active == 'add_product' ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add New</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="/admin/categories" class="nav-link {{ $active == 'categories' ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Category</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="/admin/tags/index" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tag</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="/admin/attributes/index" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Attribute</p>
            </a>
            </li>
        </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-truck"></i>
                <p>
                Order
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right" id="new-orders-count"></span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="/admin/orders" id="set-new-orders-count" class="nav-link {{ $active == 'orders' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Order</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="/admin/orders/create" class="nav-link {{ $active == 'add_order' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add New</p>
                </a>
                </li>
            </ul>
            </li>
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>

<script>
    function getNewOrdersCount() {
        let url = '{{ route('orders-count') }}'
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#new-orders-count').text(response.newOrdersCount);
            }
        });
    }

    setInterval(getNewOrdersCount, 5000);


    $('#set-new-orders-count').on('click', function() {
      
        let url = '{{ route('change-status-orders') }}'
        $.ajax({
            type: 'POST',
            url: url,
            data: { 
                status : 'old',
                _token: $('meta[name="csrf-token"]').attr("content"),
            },   
            success: function(response) {
                console.log(response)
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    });
</script>