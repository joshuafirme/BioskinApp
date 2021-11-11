@php
  $page_title =  "Bioskin";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <style>
    .btn-success {
      background-color: #06513D;
      border: #06513D;
    }

    .btn-outline-success {
    }
  </style>

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


        <!-- CATEGORIES -->

        

    </div>   

    <h4 class="text-center mt-4 text-dark">
      We can help you turn your vision into a reality!
    </h4>
    <h4 class="text-center text-dark">
      Start your SKINCARE and COSMETICS business with us.
    </h4>

    <p class="text-center mt-5 text-dark">
      <span class="m-3">ISO 9001:2015 Certified</span>|<span class="m-3">FDA Approved</span>|
      <span class="m-3">Plant-based & cruelty-free</span>|<span class="m-3">Over 10 years of manufacturing experience</span>
    </p>

    <div class="row justify-content-center">

    </div>

        <div class="loader-container">
          <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
      </div>
        <div class="row" id="product-container" style="min-height: 700px;"></div>
        
  </div>
  <!-- /.content-wrapper -->

@include('footer')