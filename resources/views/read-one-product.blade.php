@php
  $page_title =  "Bioskin";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <style>

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
                  <li class="breadcrumb-item"><a href="{{url('/shop/category/'.$category_id )}}">{{ $category_name }}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
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
        <div class="col-9 col-sm-9 col-lg-4">
            @if (isset($selected_image)) 
             <div class=" mt-5" id="main-image" style='background-image:url("{{ asset('images/'.$selected_image) }}");' ></div>
            @else 
             <div class=" mt-5" id="main-image" style='background-image:url("https://via.placeholder.com/450x450.png?text=No%20image%20available");' ></div>
            @endif
            <div class="row product-buttons mt-5">
                <div class="col-10">
                    <button class="btn btn-success btn-block m-1">Buy now</button>
                </div>
                <div class="col-2">
                    <a class="btn btn-add-cart"><img src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/34/000000/external-shopping-cart-ecommerce-kiranshastry-lineal-kiranshastry.png"/></a>
                </div>
                @if ($product->rebranding == 1)
                <div class="col-12">
                    <a href="{{ url('/rebrand/'.$product->sku.'/'.$category_name) }}" class="btn btn-outline-secondary btn-block m-1">Rebrand now!</a>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 col-lg-5">
            <div class="ml-3 mt-4 product-information">
                <h4 class="text-dark text-bold">{{ $product->name }}</h4>
                <div>{{ $product->size }}</div>
                <div>₱{{ $product->price }}</div>
                <hr>
                <div> 
                  <div class="text-bold">Choose variation</div>
                  @if ($variation)
                  @foreach ($variation as $key => $item)
                    @php
                        $active = $item->sku == $product->sku ? "active" : "";
                    @endphp
                    @if (count($variation) > 0 && $item->variation != null)
                      <button class="btn btn-light btn-variation {{$active}}" data-sku="{{ $item->sku }}">{{ $item->variation }}</button>
                    @else 
                      @if ($key == count($variation) -1)
                      <button class="btn btn-light">None</button>
                      @endif 
                    @endif
                  @endforeach
                  @else
                  <button class="btn btn-light">None</button>
                  @endif
                </div>
                <hr>
                <div class="p-details mt-2">
                    <div class="text-bold">Description</div>
                    <span id="description-text">{{ $product->description }}</span>
                </div>
                <div class="p-details mt-2" id="detail-hide-direction" style="height:53px;">
                  <div class="text-bold">Directions <span class="btn float-right btn-show-hide" object="direction">+</span></div>
                  <span id="dots-btn-direction">&#8203;</span><span id="direction-text">{{ $product->directions }}</span>
              </div>
                <div class="p-details mt-2" id="detail-hide-precaution" style="height:53px;">
                    <div class="text-bold">Precautions <span class="btn float-right btn-show-hide" object="precaution">+</span></div>
                    <span id="dots-btn-precaution">&#8203;</span><span id="precaution-text">{{ $product->precautions }}</span>
                </div>
                <div class="p-details mt-2" id="detail-hide-ingredient" style="height:53px;">
                    <div class="text-bold">Ingredients <span class="btn float-right btn-show-hide" object="ingredient">+</span></div>
                    <span id="dots-btn-ingredient">&#8203;</span><span id="ingredient-text">{{ $product->ingredients }}</span>
                </div>
                
            </div>
        </div>
    </div>
        

  
        
  </div>
  <!-- /.content-wrapper -->

@include('footer')
<script src="{{asset('js/customer/read-one.js')}}"></script>