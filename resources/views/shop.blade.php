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

      @foreach ($categories as $item)
        <a class="col-xs-6 col-sm-4 col-md-1 text-center" href="{{ url('/shop/category/'.$item->id) }}">
          <div class="text-bold text-muted category-name"  data-id="{{ $item->id }}" 
            data-name="{{ $item->name }}" >
            {{ $item->name }}</div> 
          </a>
      @endforeach

    </div> 

    <div class="row m-4">
        <div class="col-sm-12 col-md-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Shop</li>
                </ol>
              </nav>
              <ul class="bg-white" style="list-style-type: none;">
                <li class=""><a href="#">Home</a></li>
                <li class=" active" aria-current="page">Shop</li>
              </ul>
        </div>
        <div class="col-sm-12 col-md-10">
            <h4 class="text-center mt-4 text-dark mt-5">
                Shop Now!
              </h4>
              <h5 class="text-center text-dark">
                  Offers a natural skin care and cosmetics products for clients who want to create their own brand name with the finished goods available for retail/wholesale.  
              </h5>
          
              <div class="splide mt-5" id="secondary-slider" style="width:100%; margin: 0 auto;">
                  <div class="splide__track">
                    <ul class="splide__list">
                      @foreach ($categories as $item)
                      <div class="splide__slide row min-ht ml-sm-0">
                          <div class="card shadow-none category-container" style="width: 100%;">
                            <div class="responsive-img" style='background-image:url("{{ asset('images/'.$item->image) }}");' ></div>
                              <div class="card-body mx-auto">
                                <p class="card-title text-muted">{{ $item->name }}</p>
                              </div>
                            </div>
                      </div>
                      @endforeach
                    </ul>
                  </div>
                </div>
        </div>
    </div>
        

  
        
  </div>
  <!-- /.content-wrapper -->

@include('footer')