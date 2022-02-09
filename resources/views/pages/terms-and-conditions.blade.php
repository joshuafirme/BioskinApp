@php
$page_title = 'Terms and Conditions | Bioskin';
$categories = Utils::readCategories();
$data = json_decode(Cache::get('cache_contact_us'),true);
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
        @foreach ($categories as $item)
            <a class="p-1 ml-3 mr-3 text-center" href="{{ url('/shop/category/' . $item->id) }}">
                <div class="text-muted category-name" data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                    {{ $item->name }}</div>
            </a>
        @endforeach

    </div>

    <div class="container">
        <div class="card mt-5 p-3">
            <b class="text-center">PRIVATE LABEL TERMS AND CONDITIONS</b>
            {!!isset(Cache::get('cache_terms_and_cond')) ? Cache::get('cache_terms_and_cond') : "" !!}
        </div>
    </div>
    <!-- /.content-wrapper -->

    @include('footer')
