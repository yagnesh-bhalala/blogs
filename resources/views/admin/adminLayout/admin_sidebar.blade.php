<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/admin/dashboard') }}" class="brand-link">
        <img src="{{ url('public/img/mailLogo.png') }}" alt="5$ Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">B-DEMO</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url('public/backend/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    @if(Auth::check())
                        {{ ucwords(Auth::User()->firstName) }}
                    @endif
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                

                @if(Session::get('page')=="article")
                    <?php $active = "active"; ?>
                @else
                    <?php $active = ""; ?>
                @endif
                <li class="nav-item has-treeview">
                    <a href="{{ url('/admin/get-articles') }}" class="nav-link {{ $active }}">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>Articles</p>
                    </a>
                </li>

               
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>