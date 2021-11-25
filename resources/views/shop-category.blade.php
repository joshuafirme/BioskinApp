@php
  $page_title =  "Bioskin";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div ></div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="row pl-3 pr-3 pt-1 pb-1 category-container justify-content-center" style="margin-top: 11px; background-color: #EFF6EC;">
    </div> 

    <div class="row m-4">
        <div class="col-sm-12 col-md-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                  <li class="breadcrumb-item"><a href="/">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>
                  <li class="breadcrumb-item active" aria-current="page"></li>
                </ol>
              </nav>
              <ul class="bg-white" style="list-style-type: none;">
                <li class="">Choose from shop</li>
                <li class="active" aria-current="page"></li>
                <ul class="bg-white subcategory-container" style="list-style-type: none;">
                </ul>
              </ul>
        </div>
        <div class="col-sm-12 col-md-10">
            <h4 class="text-center mt-4 text-dark mt-5 selected-category-name"></h4>
              <h5 class="text-center text-dark">
                Everything new, now and need to know in beauty and skincare is here. 
                From all new formulas to latest skincare and cosmetics is yours to shop
                
              </h5>
              <div class="row mt-5" id="product-container">
              </div>
          
              <div class="row justify-content-center mt-5">
                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
              </div>
        </div>
    </div>
        

  
        
  </div>
  <!-- /.content-wrapper -->

@include('footer')
<script src="{{asset('js/customer/product.js')}}"></script>