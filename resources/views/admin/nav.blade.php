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

      <!-- 
      **ACCESS LEVELS**
        Sales Clerk = 1
        Inventory Clerk = 2
        Owner = 3
        Administrator = 4
      -->
      @php
       //   $access_level = Auth::user()->access_level;
      @endphp
      
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="{{ url('/manage-order') }}" class="nav-link">
                <i class="fas fa-shopping-cart nav-icon"></i>
                <p>Manage Orders</p>
              </a>
            </li>
              <li class="nav-item">
                <a href="{{ url('/users') }}" class="nav-link">
                  <i class="fas fa-user nav-icon"></i>
                  <p>User Management</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/voucher') }}" class="nav-link">
                  <i class="fas fa-gifts nav-icon"></i>
                  <p>Vouchers</p>
                </a>
              </li>
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
                      <i class="fas fa-cube nav-icon"></i>
                      <p>Product</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/category') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/subcategory') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sub Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/packaging') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Packaging</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/variation') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Variation</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/courier') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Courier</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/carousel') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Carousel</p>
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