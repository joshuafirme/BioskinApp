@php
  $page_title =  "Bioskin";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <style>
    .nav-item .active{
      background: #FFF !important;
      color: #424C8E !important;
      border-bottom: 2px solid #424C8E !important;
      border-radius: 0 !important;
    }

    .nav-pills{
      border-bottom: 1px solid #EBEBEB !important;
    }

    .nav-link:hover{
      color: #424C8E !important;
    }

      .p-details{
          background-color: #F2F2F2;
          padding: 15px;
          border-radius: 15px;
      }
      #direction-text {display: none;}
      #precaution-text {display: none;}
      #ingredient-text {display: none;}

      #read-one-slider .splide-other-img{

        border-radius:15px;
        cursor: pointer;
      }
      .splide-other-img:not(:first-child) {
        opacity: 0.6;
      }
      .product-information .btn-show-hide{
        margin-top: -10px;
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

    <input type="hidden" id="category-value" value="{{ $category_name }}">
    <input type="hidden" id="category-id-value" value="{{ $category_id }}">
    <div class="row pl-3 pr-3 pt-1 pb-1 justify-content-center" style="margin-top: 11px; background-color: #EFF6EC;">
        @foreach ($categories as $item)
        <a class="col-xs-6 col-sm-4 col-md-1 text-center" href="{{ url('/shop/category/'.$item->id) }}">
          <div class="text-bold text-muted category-name"  data-id="{{ $item->id }}" 
            data-name="{{ $item->name }}" >
            {{ $item->name }}</div> 
          </a>
      @endforeach
    </div> 

    <div class="row m-4">
        <div class="col-md-12 col-lg-2 breadcrumb-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                  <li class="breadcrumb-item"><a href="/">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>
                  <li class="breadcrumb-item"><a href="{{url('/shop')}}">{{ $category_name }}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                  <li class="breadcrumb-item active" aria-current="page">Rebranding</li>
                </ol>
              </nav>
             <div class="card shadow-none" style="background-color: #F2F2F2;">
              <ul style="list-style-type: none;" class=" mt-3">
                <li class="">Choose from shop</li>
                <li aria-current="page">{{ $category_name }}</li>
              </ul>
              <ul class="subcategory-container" style="list-style-type: none;">
                @foreach ($subcategories as $item)
                  <li class=""><a style="cursor:pointer;" href="{{ url('/shop/subcategory/'.$item->id) }}" class="subcategory-name">{{ $item->name }}</a></li>
                @endforeach
              </ul>
             </div>
        </div>
        <div class="col-3 col-sm-3 col-lg-1 mt-5">
          <div class="splide" id="read-one-slider">
            <div class="splide__track">
              <ul class="splide__list">
                @foreach ($images as $item)
                <div class="splide__slide row min-ht splide-other-img" data-id="{{ $item->id }}" data-src="{{ 'images/'.$item->image }}">
                  <img class="img-fluid" src="{{ asset('images/'.$item->image) }}">
                </div>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        <div class="col-9 col-sm-9 col-lg-3">
            @if (isset($selected_image)) 
             <div class=" mt-5" id="main-image" style='background-image:url("{{ asset('images/'.$selected_image) }}");' ></div>
            @else 
             <div class=" mt-5" id="main-image" style='background-image:url("https://via.placeholder.com/450x450.png?text=No%20image%20available");' ></div>
            @endif
            <div class="row product-buttons mt-2">
                <div class="col-10">
                    <button class="btn btn-success btn-block m-1">Buy now</button>
                </div>
                <div class="col-2">
                    <a class="btn btn-add-cart"><img src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/34/000000/external-shopping-cart-ecommerce-kiranshastry-lineal-kiranshastry.png"/></a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-3">
            <div class="ml-3 mt-4 product-customization">
                <h4 class="text-dark text-bold">Product Customization</h4>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Volume</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Size</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Packaging</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-cap-tab" data-toggle="pill" href="#pills-cap" role="tab" aria-controls="pills-cap" aria-selected="false">Cap</a>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row">
                      @foreach ($volumes as $key => $item)
                      <div class="col-sm-12 col-md-6">
                        <button class="btn btn-light btn-volume btn-block m-1" data-sku="{{ $product->sku }}">{{ $item }}</button>
                      </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="row">
                      @foreach ($sizes as $key => $item)
                      <div class="col-sm-12 col-md-6">
                        <button class="btn btn-light btn-volume btn-block m-1" data-sku="{{ $product->sku }}">{{ $item->size }}</button>
                      </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="row">
                      @foreach ($packagings as $key => $pack)
                      @php
                          $packaging_image = \DB::table('product_images')->where('sku', $pack->sku)->value('image');
                
                      @endphp
                      <div class="col-6 col-md-6">
                        <button class="btn btn-light btn-packaging btn-block m-1" data-sku="{{ $product->sku }}">{{ $pack->name }} {{ $pack->size }}</button>
                        <div class="  m-1 rebrand-img" style='background-image:url("{{ asset('images/'.$packaging_image) }}");' ></div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="tab-pane fade" id="pills-cap" role="tabpanel" aria-labelledby="pills-cap-tab">
                    <div class="row">
                      @foreach ($closures as $key => $closure)
                      @php
                          $closure_image = \DB::table('product_images')->where('sku', $closure->sku)->value('image');
                
                      @endphp
                      <div class="col-6">
                        <button class="btn btn-light btn-packaging btn-block m-1" data-sku="{{ $product->sku }}">{{ $closure->name }} {{ $closure->size }}</button>
                        <div class="  m-1 rebrand-img" style='background-image:url("{{ asset('images/'.$closure_image) }}");' ></div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
                
            </div>
        </div>
        <div class="col-md-12 col-lg-3"></div>
    </div>
        

  
        
  </div>
  <!-- /.content-wrapper -->

@include('footer')
<script src="{{asset('js/customer/read-one.js')}}"></script>