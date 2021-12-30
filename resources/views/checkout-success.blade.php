@php
  $page_title = "Cart | Bioskin";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <style>
    
    table {
        border-collapse: collapse !important;
    }
    .table-container {
        overflow-x: auto;
    }
    th, td {
        padding: 10px !important;
    }
    td {
        padding: 10px !important; 
        margin: 0 !important;
    }
    thead{
        position: sticky !important;
        top: 0 !important;
        background-color: #FFF;
        border-color: #C4BFC2;
        z-index: 999;
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

    <div class="row pl-3 pr-3 pt-1 pb-1 justify-content-center" style="margin-top: 11px; background-color: #EFF6EC;">
        @php
            if (\Cache::get('categories-cache')) {
                $cache_categories = \Cache::get('categories-cache');
            }
            else {
                $cache_categories = \App\Models\Category::where('status', 1)->get();
            }
        @endphp
        @foreach ($cache_categories as $item)
        <a class="p-1 ml-3 mr-3 text-center" href="{{ url('/shop/category/'.$item->id) }}">
          <div class="text-muted category-name"  data-id="{{ $item->id }}" 
            data-name="{{ $item->name }}" >
            {{ $item->name }}</div> 
          </a>
      @endforeach
    </div> 
  <div class="container">
    <div class="card mt-5">
        <div class="card-body">
            <div class="alert alert-success">
                <h4 class="alert-heading">{{ $response_message }}</h4>
                <p>{{ $response_advise }}</p>
                <p>{{ $processor_response_id }}</p>
            </div>
        </div>
    </div>
  </div>
  </div>
    
  <!-- /.content-wrapper -->

@include('footer')
<script src="{{asset('js/customer/cart.js')}}"></script>
<script>
    let h = $(document).height()-300;
  //  $('#cart-table').css('min-height', h);
</script>