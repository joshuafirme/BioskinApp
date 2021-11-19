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
    .second-row .card{
      -webkit-box-shadow: none;
      -moz-box-shadow: none;
      box-shadow: none;
    }
    .second-row img{
      object-fit: contain !important;
      height: 330px;
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

    .bs4-order-tracking {
    margin-bottom: 30px;
    overflow: hidden;
    color: #878788;
    padding-left: 0px;
    margin-top: 30px
}

.bs4-order-tracking li {
    list-style-type: none;
    font-size: 13px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400;
    color: #878788;
    text-align: center
}

.bs4-order-tracking li:first-child:before {
    margin-left: 15px !important;
    padding-left: 11px !important;
    text-align: left !important
}

.bs4-order-tracking li:last-child:before {
    margin-right: 5px !important;
    padding-right: 11px !important;
    text-align: right !important
}

.bs4-order-tracking li>div {
    color: #fff;
    width: 29px;
    text-align: center;
    line-height: 29px;
    display: block;
    font-size: 12px;
    background: #878788;
    border-radius: 50%;
    margin: auto
}

.bs4-order-tracking li:after {
    content: '';
    width: 150%;
    height: 2px;
    background: #878788;
    position: absolute;
    left: 0%;
    right: 0%;
    top: 15px;
    z-index: -1
}

.bs4-order-tracking li:first-child:after {
    left: 50%
}

.bs4-order-tracking li:last-child:after {
    left: 0% !important;
    width: 0% !important
}

.bs4-order-tracking li.active {
    font-weight: bold;
}

.bs4-order-tracking li.active>div {
    background: #3BC265
}

.bs4-order-tracking li.active:after {
    background: #3BC265;
}

.card-timeline {
    background-color: #fff;
    z-index: 0;
    box-shadow: none;
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
      <div class="col-md-12  col-lg-4" style="padding:0;">
          <div class="card card-timeline">
            <ul class="bs4-order-tracking">
                <li class="step active"></li>
                <li class="step active">
                    <div><i class="fas fa-flask"></i></div> Formulation
                </li>
                <li class="step active">
                    <div><i class="fas fa-check-circle"></i></div> Stability Testing
                </li>
                <li class="step active">
                    <div><i class="fas fa-cube"></i></div> Packaging Solutions
                </li>
                <li class="step active"></li> 
                <li class="step active"></li>
              
            </ul>
            
        </div>
      </div>
      <div class="col-md-12  col-lg-4" style=" padding:0;">
        <div class="card card-timeline">
          <ul class="bs4-order-tracking">
              <li class="step active"></li>
              <li class="step active">
                <div><i class="fas fa-bread-slice"></i></div> Compounding
              </li>
              <li class="step active">
                  <div><i class="fas fa-burn"></i></div> Filling
              </li>
              <li class="step active">
                  <div><i class="fas fa-tags"></i></div> Labelling
              </li>
              <li class="step active">
                <div><i class="fas fa-flag-checkered"></i></div> Finish Goods
            </li>
              <li class="step active"></li>
          </ul>
      </div>
    </div>
    <div class="col-md-12  col-lg-4" style=" padding:0;">
      <div class="card card-timeline">
        <ul class="bs4-order-tracking third-order-tracking">
          <li class="step active"></li> 
            <li class="step active">
              <div><i></i></div>&#8203;
            </li>
            <li class="step active">
                <div><i class="fas fa-warehouse"></i></div> Warehousing
            </li>
            <li class="step active">
              <div><i class="fas fa-truck-moving"></i></div> Shipping
          </li>
            <li class="step active"></li> 
            <li class="step active"></li>
        </ul>
        
    </div>
  </div>
    </div>
    
    <div class="row m-5 second-row justify-content-center">
      <div class="card"><div class="col-sm-12 col-md-4"><img src="{{ asset('images/fomulation.png') }}" alt=""></div></div>
      <div class="card"><div class="col-sm-12 col-md-4"><img src="{{ asset('images/finish_goods.png') }}" alt=""></div></div>
      <div class="card"><div class="col-sm-12 col-md-4"><img src="{{ asset('images/shipping.png') }}" alt=""></div></div>
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