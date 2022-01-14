@php
$page_title = $product->name . ' | Rebranding | Bioskin';
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

<style>
    .item-value {
        background: #E2E6EA;
        padding: 5px 15px 5px 15px !important;
        border-radius: 5px;
        margin-top: 10px;
    }

    .attr-container .active {
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, #D9D9D9 0px 0px 0px 3px !important;
    }

    .nav-item .active {
        background: #FFF !important;
        color: #424C8E !important;
        border-bottom: 2px solid #424C8E !important;
        border-radius: 0 !important;
    }

    .nav-pills {
        border-bottom: 1px solid #EBEBEB !important;
    }
    .nav-link:hover {
        color: #424C8E !important;
    }
    .nav-link.active:hover {
        color: #424C8E !important;
    }

    .p-details {
        background-color: #F2F2F2;
        padding: 15px;
        border-radius: 15px;
    }

    #direction-text {
        display: none;
    }

    #precaution-text {
        display: none;
    }

    #ingredient-text {
        display: none;
    }

    #read-one-slider .splide-other-img {
        border: 1px solid #E2E6EA !important;
        border-radius: 15px;
        cursor: pointer;
    }

    .splide-other-img:not(:first-child) {
        opacity: 0.6;
    }

    .product-information .btn-show-hide {
        margin-top: -10px;
    }

    .summary-container {
        background-color: #F2F2F2;
        padding: 15px;
        border: 2px solid #E2E6EA !important;
    }

</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div></div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <input type="hidden" id="category-value" value="{{ $category_name }}">
    <input type="hidden" id="category-id-value" value="{{ $category_id }}">
    <div class="row pl-3 pr-3 pt-1 pb-1 justify-content-center" style="margin-top: 11px; background-color: #EFF6EC;">
        @foreach ($categories as $item)
            <a class="p-1 ml-3 mr-3 text-center" href="{{ url('/shop/category/' . $item->id) }}">
                <div class="text-muted category-name" data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                    {{ $item->name }}</div>
            </a>
        @endforeach
    </div>
    <div class="breadcrumb-container ml-2 mt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/shop') }}">{{ $category_name }}</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ url('/shop/' . $product->sku . '/' . $category_name) }}">{{ $product->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rebranding</li>
            </ol>
        </nav>
    </div>
    <div class="row ml-3 mr-3">
        <div class="col-md-12 col-lg-2 breadcrumb-container">

            <div class="card shadow-none" style="background-color: #F2F2F2;">
                <ul style="list-style-type: none;" class=" mt-3">
                    <li class="">Choose from shop</li>
                    <li aria-current="page">{{ $category_name }}</li>
                </ul>
                <ul class="subcategory-container" style="list-style-type: none;">
                    @foreach ($subcategories as $item)
                        <li class=""><a style="cursor:pointer;"
                                href="{{ url('/shop/subcategory/' . $item->id) }}"
                                class="subcategory-name">{{ $item->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-3 col-sm-3 col-lg-1 mt-5 mb-4">
            <div class="splide" id="read-one-slider">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($images as $item)
                            <div class="splide__slide row min-ht splide-other-img" data-id="{{ $item->id }}"
                                data-src="{{ 'images/' . $item->image }}">
                                <img class="img-fluid" src="{{ asset('images/' . $item->image) }}">
                            </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-9 col-sm-9 col-lg-3">
            @if (isset($selected_image))
                <div class="responsive-img mt-5" id="main-image"
                    style='background-image:url("{{ asset('images/' . $selected_image) }}");'></div>
            @else
                <div class="responsive-img mt-5" id="main-image"
                    style='background-image:url("https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png");'>
                </div>
            @endif
                <div class="m-2"> 
                    <a class="btn btn-add-cart float-lg-right" data-sku="{{ $product->sku }}" data-price="{{ $product->price }}"
                        data-order-type="1"><img
                            src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/34/000000/external-shopping-cart-ecommerce-kiranshastry-lineal-kiranshastry.png" /></a>
                  
                  <div id="size-value">{{ $product->size }}</div>
                  <div id="price-value">₱{{ $product->price }}</div>
                  <div id="qty-value">Qty: {{ $product->qty }}</div>
                </div>
            <div class="row product-buttons mt-2">
        
                <div class="col-2">
                    <input type="hidden" id="price_by_volume_hidden">
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="ml-3 mt-4 product-customization">
                <h4 class="text-dark text-bold">Product Customization</h4>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-sizes-tab" data-toggle="pill" href="#pills-sizes"
                            role="tab" aria-controls="pills-sizes" aria-selected="true">Size</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-volumes-tab" data-toggle="pill" href="#pills-volumes"
                            role="tab" aria-controls="pills-volumes" aria-selected="false">Volume</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-packaging-tab" data-toggle="pill" href="#pills-packaging"
                            role="tab" aria-controls="pills-packaging" aria-selected="false">Packaging</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-cap-tab" data-toggle="pill" href="#pills-cap" role="tab"
                            aria-controls="pills-cap" aria-selected="false">Cap</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active  attr-container" id="pills-sizes" role="tabpanel"
                        aria-labelledby="pills-sizes-tab">
                        <div class="row">
                            @if (count($sizes) > 0)
                                @foreach ($sizes as $key => $item)
                                    @php
                                        $active = $item->size == $product->size ? 'active' : '';
                                        $packaging_ids = isset($item->packaging) ? implode(',', $item->packaging) : '';
                                        $closure_ids = isset($item->closures) ? implode(',', $item->closures) : '';
                                    @endphp
                                    <div class="col-sm-12 col-md-6">
                                        <button class="btn btn-light btn-size btn-block m-1 {{ $active }}"
                                            data-price="{{ $item->price }}" data-size="{{ $item->size }}"
                                            data-sku="{{ $item->sku }}" data-packaging-ids="{{ $packaging_ids }}"
                                            data-closure-ids="{{ $closure_ids }}">{{ $item->size }}</button>
                                    </div>
                                @endforeach
                            @else
                                @php
                                    $packaging_ids = isset($product->packaging) ? implode(',', $product->packaging) : '';
                                    $closure_ids = isset($product->closures) ? implode(',', $product->closures) : '';
                                @endphp
                                <button class="btn btn-light btn-size m-1 active" data-price="{{ $product->price }}"
                                    data-size="{{ $product->size }}" data-sku="{{ $product->sku }}"
                                    data-packaging-ids="{{ $packaging_ids }}"
                                    data-closure-ids="{{ $closure_ids }}">{{ $product->size }}</button>
                            @endif
                        </div>
                        <!--<h5 class="mt-4">Price </h5>
                     <span class="item-value" id="size-price">0.00</span>-->
                    </div>
                    <div class="tab-pane fade attr-container" id="pills-volumes" role="tabpanel"
                        aria-labelledby="pills-volumes-tab">
                        <div class="row" id="volumes-container">
                            @foreach ($volumes as $key => $item)
                                @php
                                    $active = '';
                                @endphp
                                @if ($key == 0)
                                    @php
                                        $active = 'active';
                                    @endphp
                                @endif
                                <div class="col-sm-12 col-md-6">
                                    <button class="btn btn-light btn-volume btn-block m-1 {{ $active }}"
                                        data-sku="{{ $product->sku }}" data-volume="{{ $item->volume }}"
                                        data-price="{{ $item->price }}">{{ $item->volume }}</button>
                                </div>
                            @endforeach
                        </div>
                        <h5 class="mt-4">Price </h5>
                        <span class="item-value" id="volume-price">0.00</span>
                    </div>
                    <div class="tab-pane fade attr-container" id="pills-packaging" role="tabpanel"
                        aria-labelledby="pills-packaging-tab">
                        <div class="row packaging-container">
                            @php
                                $selected_packaging_price = 0.0;
                            @endphp
                            @if (count($packagings) > 0)
                                @foreach ($packagings as $key => $pack)
                                    @php
                                        $packaging_image = \DB::table('product_images')
                                            ->where('sku', $pack->sku)
                                            ->value('image');
                                        
                                        if ($key == 0 && $product->packaging_price_included == 1) {
                                            $selected_packaging_price = $pack->price;
                                            $pack->price = '0.00';
                                        } elseif ($key > 0 && $product->packaging_price_included == 1) {
                                            if ($selected_packaging_price < $pack->price) {
                                                $pack->price = (float) $pack->price - (float) $selected_packaging_price;
                                            } else {
                                                $pack->price = (float) $selected_packaging_price + (float) $pack->price;
                                            }
                                        }
                                    @endphp
                                    <div class="col-6 col-md-6">
                                        <button class="btn btn-light btn-packaging btn-block m-1"
                                            data-sku="{{ $pack->id }}"
                                            data-price="{{ number_format($pack->price, 2, '.', ',') }}"
                                            data-name="{{ $pack->name }} {{ $pack->size }}">
                                            {{ $pack->name }} {{ $pack->size }}
                                        </button>
                                        @if ($packaging_image)
                                            <div class="  m-1 rebrand-img"
                                                style='background-image:url("{{ asset('images/' . $packaging_image) }}");'>
                                            </div>
                                        @else
                                            <div class="  m-1 rebrand-img"
                                                style='background-image:url("https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png");'>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="mx-auto text-muted">No available packaging</p>
                            @endif
                        </div>
                        <h5 class="mt-4">Price </h5>
                        <span class="item-value" id="packaging-price">0.00</span>
                    </div>
                    <div class="tab-pane fade attr-container" id="pills-cap" role="tabpanel"
                        aria-labelledby="pills-cap-tab">
                        <div class="row closure-container">
                            @if (count($closures) > 0)
                                @foreach ($closures as $key => $closure)
                                    @php
                                        $closure_image = \DB::table('product_images')
                                            ->where('sku', $closure->sku)
                                            ->value('image');
                                        if ($key == 0 && $product->closure_price_included == 1) {
                                            $closure->price = '0.00';
                                        }
                                    @endphp
                                    <div class="col-6">
                                        <button class="btn btn-light btn-closure btn-block m-1"
                                            data-price="{{ $closure->price }}" data-sku="{{ $closure->id }}"
                                            data-name="{{ $closure->name }} {{ $closure->size }}">
                                            {{ $closure->name }} {{ $closure->size }}
                                        </button>

                                        @if ($closure_image)
                                            <div class="  m-1 rebrand-img"
                                                style='background-image:url("{{ asset('images/' . $closure_image) }}");'>
                                            </div>
                                        @else
                                            <div class="  m-1 rebrand-img"
                                                style='background-image:url("https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png");'>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="mx-auto text-muted">No available cap</p>
                            @endif
                        </div>
                        <h5 class="mt-4">Price </h5>
                        <span class="item-value" id="closure-price">0.00</span>
                    </div>
                </div>

            </div>
            <hr>
            <small class="text-danger attr-validation"></small>
        </div>
        <div class="col-md-12 col-lg-2">
            <div class="ml-3 mt-4 product-customization">
                <h4 class="text-dark text-bold">Summary of Order</h4>

                <div class="summary-container">
                    <div class="text-bold text-center">Size</div>
                    <div class="text-center"><span id="custom-size"></span></div>
                </div>

                <div class="summary-container mt-2">
                    <div class="text-bold text-center">Volume</div>
                    <div class="text-center"><span class="custom-volume">-</span> pieces * <span
                            id="custom-price">-</span></div>
                    <div>₱<span id="volume-total-price"> 0</span></div>
                </div>

                <div class="summary-container mt-2">
                    <div class="text-bold text-center">Packaging</div>
                    <div class="text-center"><span id="custom-packaging">-</span></div>
                    <div class="text-center"><span class="custom-volume">-</span> pieces * <span
                            id="custom-packaging-price">-</span></div>
                    <div>₱<span id="packaging-total-price"> 0</span></div>
                </div>

                <div class="summary-container mt-2">
                    <div class="text-bold text-center">Cap</div>
                    <div class="text-center"><span id="custom-closure">-</span></div>
                    <div class="text-center"><span class="custom-volume">-</span> pieces * <span
                            id="custom-closure-price">-</span></div>
                    <div>₱<span id="closure-total-price"> 0</span></div>
                </div>

                <div class="summary-container mt-2">
                    <div class="text-bold text-center">Total</div>
                    <div>₱<span id="overall-total-price"> 0</span></div>
                </div>
            </div>
        </div>

    </div>



</div>
<!-- /.content-wrapper -->

@include('footer')
<script src="{{ asset('js/customer/read-one.js') }}"></script>
@include('scripts._cart')
