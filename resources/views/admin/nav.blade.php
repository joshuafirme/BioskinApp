  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/home') }}" target="_blank" aria-haspopup="true" aria-expanded="false" class="nav-link">View website</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
   
      @php
        $allowed_modules_array = explode(",",\Auth::user()->allowed_modules);
      @endphp 
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" id="notif-bell">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge" id="total-notif"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification-container">
          <span class="dropdown-item dropdown-header">No notification</span>
        </div>
      </li>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{ Auth::user()->firstname }}</a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
          <li><a href="{{url('/logout')}}" class="dropdown-item">Logout </a></li>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('images/logo.png')}}" alt="AdminLTE Logo" class="brand-image " style="opacity: 1;">
      <span class="brand-text font-weight-light" style="font-size: 16px;">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @php
              $user = Auth::user();
          @endphp
          @if ($user->image) 
               <img class="img-circle elevation-2" src="{{ asset('/images/'.$user->image) }}"/>
          @else 
              <img src="https://img.icons8.com/small/75/ffffff/user-male-circle.png"/>
          @endif
        </div>
        <div class="info">
          <a href="#" class="d-block">{{$user->firstname}} {{$user->lastname}}</a>
        </div>
      </div>

      @php
                
          $allowed_pages = explode(",",$user->allowed_pages);
       
      @endphp
      
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @if(in_array("Dashboard", $allowed_pages))
            <li class="nav-item">
              <a href="{{ url('/dashboard') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
            </li>
            @endif

            @if(in_array("Manage Orders", $allowed_pages))
            <li class="nav-item">
              <a href="{{ url('/manage-order') }}" class="nav-link">
                <i class="fas fa-shopping-cart nav-icon"></i>
                <p>Manage Orders</p>
              </a>
            </li>
            @endif

            @if(in_array("Users", $allowed_pages))
              <li class="nav-item">
                <a href="{{ url('/users') }}" class="nav-link">
                  <i class="fas fa-user nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
            @endif

            @if(in_array("Vouchers", $allowed_pages))
              <li class="nav-item">
                <a href="{{ url('/voucher') }}" class="nav-link">
                  <i class="fas fa-gifts nav-icon"></i>
                  <p>Vouchers</p>
                </a>
              </li>
            @endif

            @if(in_array("Maintenance", $allowed_pages))
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tools"></i>
                  <p>
                    Maintenance
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/product') }}" class="nav-link">
                      
                      <p class="ml-3">Product</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/category') }}" class="nav-link">
                      
                      <p class="ml-3">Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/subcategory') }}" class="nav-link">
                      
                      <p class="ml-3">Sub Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/packaging') }}" class="nav-link">
                      
                      <p class="ml-3">Packaging</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/variation') }}" class="nav-link">
                      
                      <p class="ml-3">Variation</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/courier') }}" class="nav-link">
                      
                      <p class="ml-3">Courier</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/carousel') }}" class="nav-link">
                      
                      <p class="ml-3">Carousel</p>
                    </a>
                  </li>
                </ul>
              </li>
              @endif
              @if(in_array("Archive", $allowed_pages))
              <li class="nav-item">
                <a href="{{ url('/archive') }}" class="nav-link">
                    <i class="nav-icon fas fa-archive"></i>
                    <p>
                      Archive
                    </p>
                  </a>
              </li>
              @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>