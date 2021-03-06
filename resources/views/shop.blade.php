@php
$page_title = 'Shop | Bioskin';
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

@include('includes.categories-menu')

<div class="row m-4">
    <div class="col-sm-12 col-md-2 breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop</li>
            </ol>
        </nav>
        <ul class="bg-white" style="list-style-type: none;">
            <li class="">Choose from shop</li>
            <button type="button" class="navbar-toggler navbar-toggle x collapsed" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button> 
            <div class="collapse" id="navbarToggleExternalContent">
                @foreach ($categories as $item)
                    <li class=""><a href="{{ url('/shop/category/' . $item->id) }}">{{ $item->name }}</a>
                    </li>
                @endforeach
            </div>
        </ul>
    </div>
    <div class="col-sm-12 col-md-10">
        <h4 class="text-center mt-4 text-dark mt-5">
            Shop Now!
        </h4>
        <h5 class="text-center text-dark">
            Offers a natural skin care and cosmetics products for clients who want to create their own brand name with
            the finished goods available for retail/wholesale.
        </h5>

        <div class="splide mt-5 landing" id="secondary-slider" style="width:100%; margin: 0 auto;">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($categories as $item)
                        <div class="splide__slide row min-ht ml-sm-0">
                            <div class="card shadow-none category-container" style="width: 100%;">
                                <a href="{{ url('/shop/category/' . $item->id) }}">
                                    <div class="responsive-img"
                                        style='background-image:url("{{ asset('images/' . $item->image) }}");'></div>
                                </a>
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

<script>
$(function () {
    $(document).on('click', '.btn-show-hide', async function() {
        var object = $(this).attr('object');
        var dots = document.getElementById("dots-btn-" + object);
        var moreText = document.getElementById(object + "-text");
        var btnText = $(this);
        $('#detail-hide-' + object).css('height', 'auto');
        if (dots.style.display === "none") {
             dots.style.display = "inline";
            btnText.text("+");
            moreText.style.display = "none";
            $('#detail-hide-' + object).css('height', '50px');
        } else {
            dots.style.display = "none";
            btnText.text("-");
            moreText.style.display = "inline";
        }           
    });      
});        
</script>