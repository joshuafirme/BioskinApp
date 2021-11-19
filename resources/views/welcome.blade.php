@php
  $page_title =  "Bioskin";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <style>
    .carousel-container{
      -webkit-box-shadow: none;
      -moz-box-shadow: none;
      box-shadow: none;
    }
    .swiper-button-next,.swiper-button-prev{
        border: 0px !important;
        background: transparent;
        background-image:none !important;
        outline:none;
        color: #444444;
    }
    .btn-success {
      background-color: #06513D;
      border: #06513D;
    }

    .card-img-top, .carousel-img {
      object-fit: contain !important;
    }
    .card-first-imgs .card-img-top{
      background-color: #EBEBEB;
    }
    .card-first-imgs .card{
      background-color: #EBEBEB;
    }
    .bs-dr-bgn{
      object-fit: contain;
    }
    .wording-container h1{
      display: inline-block; font-size: 2.4vw; vertical-align: middle; margin-top: 20%;
    }
    .wording-container h3{
      display: inline-block; font-size: 1.5vw; vertical-align: middle; margin-top: 20px;
    }
    .wording-2{
      font-size: 1.5vw; margin-top: 20px;
    }
    @media screen and (max-width: 750px) {
      .wording-container h1{
        font-size: 25px;
        line-height: 30px;
        margin-top: 0;
      }
      .wording-container h3, .wording-2{
        font-size: 15px;
        line-height: 20px;
      }
    }

    .fa-check{
      color:#3BC265; 
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

      @foreach ($categories as $item)
        <a class="col-xs-6 col-sm-4 col-md-1 text-center" href="{{ url('/#a1b19e1a') }}">
          <div class="text-bold text-muted category-name"  data-id="{{ $item->id }}" 
            data-name="{{ $item->name }}" >
            {{ $item->name }}</div> 
          </a>
      @endforeach

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

    <div class="row ml-5 mr-5 card-first-imgs">
      <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card m-2">
          <img class="card-img-top mt-5 mb-5" src="{{ asset('images/iso.png') }}" height="330px" alt="Card image cap">
        </div>
        <div class="p-3">
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Client confidence and assurance</span></div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Business growth opportunities</span></div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Continuous quality management system implementation</span> </div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Consistent internal operations</span> </div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Continuous improvement efforts</span> </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card m-2">
          <img class="card-img-top mt-5 mb-5" src="{{ asset('images/fda.png') }}" height="330px" alt="Card image cap">
        </div>
        <div class="p-3">
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Safety</span></div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Quality</span></div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Purity</span> </div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Efficacy</span> </div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Protect and promote general public health</span> </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card m-2">
          <img class="card-img-top mt-5 mb-5" src="{{ asset('images/crueltyfree.png') }}" height="330px" alt="Card image cap">
        </div>
        <div class="p-3">
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Not tested on animals</span></div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">No animal derived ingredients</span></div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Plant-based</span> </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card m-2">
          <img class="card-img-top mt-5 mb-5" src="{{ asset('images/peta.png') }}" height="330px" alt="Card image cap">
        </div>
        <div class="p-3">
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">People for the Ethical Treatment of Animals (PETA) Member</span></div>
          <div class="m-1"><i class="fa fa-check"></i> <span class="text-bold text-muted">Establishes and defends animal rights</span></div>
        </div>
      </div>
    </div>

    <div class="row m-5">
      <div class="col-sm-12">
        <h3 class="text-muted text-center wording-2">Build an ethical, natural, and professional skincare brand with us
        </h3>
      </div>
    </div>

    <div class="row m-5">
      <div class="col-sm-12 col-md-6">
        <div class="m-5">
          <img class="bs-dr-bgn img-fluid" src="{{ asset('images/bs_dr_bgn.png') }}" alt="Card image cap">
        </div>
      </div>
      <div class="col-sm-12 col-md-6">
        <div class="text-center wording-container">
          <h1 class="text-muted">Mindanao-based skincare and cosmetics toll manufacturer.</h1>
          <h3 class="text-muted">Enjoy high quality products for low minimums and affordable prices. Contact us now!</h3>
        </div>
      </div>

      <div class="col-sm-12">
        <h3 class="text-muted text-center wording-2">Enjoy promos and discounts when you sign up here. You can now add vouchers to your checkouts for a much enjoyable shopping!</h3>
      </div>
    </div>
    <div class="splide" id="secondary-slider" style="width:88%; margin: 0 auto;">
      <div class="splide__track">
        <ul class="splide__list">
          @foreach ($carousel as $item)
          <div class="splide__slide row min-ht ml-2">
            <img src="{{ asset('images/'.$item->image)}}" class="carousel-img" alt="">
          </div>
          @endforeach
        </ul>
      </div>
    </div>

  </div>
    
        <div class="loader-container">
          <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
      </div>
        <div class="row" id="product-container" style="min-height: 700px;"></div>
        
  </div>
  <!-- /.content-wrapper -->

@include('footer')