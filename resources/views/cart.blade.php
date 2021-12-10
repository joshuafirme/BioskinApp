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
           $col_count = 1;
           $col_count = count($categories) > 9 ? '2' : '1';
      @endphp
        @foreach ($categories as $item)
        <a class="col-6 col-sm-4 col-md-1 text-center" href="{{ url('/shop/category/'.$item->id) }}">
          <div class="text-muted category-name"  data-id="{{ $item->id }}" 
            data-name="{{ $item->name }}" >
            {{ $item->name }}</div> 
          </a>
      @endforeach
    </div> 
    <div class="breadcrumb-container ml-2 mt-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
          </ol>
        </nav>
      </div>
    <div class="m-5 table-container" style="overflow-y: auto; height:550px;">
        <table class="table table-borderless mb-5" id="cart-table">
            <thead>
              <th><input type="checkbox" name="select_all" value="1" id="select-all-product"></th>
                <th>Product Ordered</th>
                <th>Item Description</th>
                <th>Variation</th>
                <th>Packaging</th>
                <th>Cap</th>
                <th>Quantity</th>
                <th>Order Subtotal</th>
            </thead>
            <tbody id="cart-item-container">
                <tr>
                    <td></td>
                    <td></td>
                    <td>   <div class="row justify-content-center mt-5">
                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                      </div></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
         
    </div>
    
    
  <!-- /.content-wrapper -->

@include('footer')
<script src="{{asset('js/customer/cart.js')}}"></script>
<script>
    let h = $(document).height()-300;
  //  $('#cart-table').css('min-height', h);
</script>