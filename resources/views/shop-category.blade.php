@php
$page_title = 'Shop | Bioskin';
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
                    <div></div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="row pl-3 pr-3 pt-1 pb-1 category-container justify-content-center"
        style="margin-top: 11px; background-color: #EFF6EC;">
    </div>

    <input type="hidden" id="category-name-hidden">
    <div class="breadcrumb-container ml-3 mt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
    </div>
    <div class="row ml-3">
        <div class="col-md-12 col-lg-2 breadcrumb-container">
            <div class="card shadow-none" style="background-color: #F2F2F2;">
                <ul style="list-style-type: none;" class=" mt-3">
                    <li class="">Choose from shop</li>
                    <li aria-current="page"></li>
                </ul>
                <ul class=" subcategory-container" style="list-style-type: none;">
                </ul>
            </div>
        </div>
        <div class="col-md-12 col-lg-10">
            <h4 class="text-center text-dark selected-category-name"></h4>
            <div class="wording-container"></div>
            <div class="row" id="product-container">
            </div>

            <div class="row justify-content-center mt-5">
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>




</div>
<!-- /.content-wrapper -->

@include('footer')
<script src="{{ asset('js/customer/product.js') }}"></script>
@include('scripts._cart')
