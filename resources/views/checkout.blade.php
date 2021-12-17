@php
  $page_title = "Checkout | Bioskin";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <style>
    .card{
        background-color: #F4F4F4;
        padding: 10px;
    }
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

    .payment-method-container button, .row .btn{
        background-color: #F2F2F2;
        padding: 7px;
        border: 2px solid #E2E6EA !important;
        margin-bottom: 10px;
        width: 180px;
        color: #000;
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
    <div class="breadcrumb-container ml-2 mt-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>
            <li class="breadcrumb-item"><a href="{{url('/cart')}}">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
          </ol>
        </nav>
    </div>

    <h3 class="text-center text-bold">Checkout</h3>
    <div class="container card delivery-address-container">
        <div class="row ml-5 mr-5">
            <div class="col-sm-12 col-md-3 mt-3">
                <img src="https://img.icons8.com/color/50/000000/marker.png"/><span class="ml-1" style=""> Delivery Address</span>
            </div>
            <div class="col-sm-12 col-md-2 mt-3">
                <div id="fullname">
                </div>
                <div id="phone_no">
                </div>
            </div>
            <div class="col-sm-12 col-md-5 mt-3">
                <div id="address">
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <button class="btn btn-secondary m-1 float-none float-md-right" id="btn-set-default">Default</button>
                <button class="btn btn-secondary m-1 float-none float-md-right" id="btn-change-address" data-toggle="modal" data-target="#checkout-address-modal">Change</button>
            </div>
        </div>
    </div>
    <div class="ml-5 mr-5 table-container" >  
        <table class="table table-borderless" id="cart-table">
            <thead style="background-color: #F4F4F4;">
                <th>Product Ordered</th>
                <th>Item Description</th>
                <th>Size</th>
                <th>Variation</th>
                <th>Packaging</th>
                <th>Cap</th>
                <th>Quantity</th>
                <th>Order Subtotal</th>
            </thead>
            <tbody id="cart-item-container">
                @php
                    $total = 0;
                @endphp
                @foreach ($cart as $item)
                @php
                    $total = $total + $item->amount;
                    $src = \DB::table('product_images')->where('sku', $item->sku)->value('image');
                @endphp
                <tr>
                    <td>
                        @if ($src)
                        <div class="responsive-img" style="width:100px; background-image:url('/images/{{ $src }}')"></div>
                        @else
                        <div class="responsive-img" style="width:100px; background-image: url('https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png')"></div>
                        @endif
                    </td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->size ?$item->size : "-"}}</td>
                    <td>{{$item->variation ? $item->variation : "-"}}</td>
                    <td>{{$item->packaging ?$item->packaging : "-"}}</td>
                    <td>{{$item->closure ? $item->closure : "-"}}</td>
                    <td>{{$item->qty}}</td>
                    <td>₱{{number_format($item->amount,2,".",",")}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>   
    </div>
    <div class="ml-5 mr-5">
      <hr>
      <div class="row">
        <div class="col-sm-3">
            <textarea class="form-control" name="" id=""rows="4" placeholder="Leave a message (Optional)"></textarea>
        </div>
        <div class="col-sm-6">
            <div class="p-3">
                <div class="text-center text-bold p-2" style="background-color: #F4F4F4;">Shipping Option</div>
                <div class="row">
                    @php
                        $courier = App\Models\Courier::where('status', 1)->first();
                    @endphp
                    <div class="col-sm-12 col-md-4">
                        <div class="text-center p-2 mt-2" style="background-color: #F4F4F4;">
                        <img src="https://img.icons8.com/external-vitaliy-gorbachev-flat-vitaly-gorbachev/25/000000/external-courier-sales-vitaliy-gorbachev-flat-vitaly-gorbachev.png"/>
                        <span class="ml-2"  id="courier_text">{{ isset($courier->name) ? $courier->name : "" }}</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="btn btn-sm btn-primary m-2" id="btn-change-courier" data-toggle="modal" data-target="#courier-modal">Change courier</div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="text-bold mt-2">Receive by</div>
                        <div id="receive_by_text">{{ isset($courier->receive_by) ? $courier->receive_by : "" }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="text-bold mt-4 mr-0 mr-sm-4 text-center">Shipment Fee</div>
            <div class="text-center mr-0 mr-sm-4 " id="shipment_fee_text">₱100.00</div>
        </div>
      </div>
    </div>
    <div class="ml-5 mr-5" style="margin-bottom: 200px;">
        <hr>
        <div class="row">
          <div class="col-sm-3 text-center payment-method-container">
              <p class="text-bold">Payment Method</p>
              <div><button>Credit/Debit Card</button></div>
              <div><button>Online Payment</button></div>
              <div><button>Cash on Delivery</button></div>
          </div>
          <div class="col-sm-9 row">
            <div class="col-sm-8">
                <div class="p-3">
                    <div class="text-center text-bold p-2" style="background-color: #F4F4F4;">Vouchers</div>
                    <div class="row">
                      <div class="col-sm-12 col-md-6">
                        <form>
                            <input id="voucher" type="text" class="form-control mt-2" placeholder="Enter voucher code">
                        </form>
                      </div>
                      <div class="col-sm-12 col-md-6">
                          <div class="text-bold mt-2">Select voucher</div>
                      </div>
                  </div>  
                </div>
            </div>
            <div class="col-sm-4">
                <div class="text-bold mt-4 text-center">Voucher Discount</div>
                <div class="text-center" id="shipment_fee_text">0.00</div>
            </div>
            <div class="col-sm-12">
               <hr>
            </div>
            <div class="col-sm-8">
                <div class="text-bold float-sm-right m-1">Merchandise Subtotal</div>
            </div>
            <div class="col-sm-4">
                <div class="text-left text-sm-center m-1" id="shipment_fee_text">₱{{number_format($total,2,".",",")}}</div>
            </div>
            <div class="col-sm-8">
                <div class="text-bold float-sm-right m-1">Shipping Total</div>
            </div>
            <div class="col-sm-4">
                <div class="text-left text-sm-center m-1" id="shipment_fee_text">0.00</div>
            </div>
            <div class="col-sm-8">
                <div class="text-bold float-sm-right m-1">Voucher Discount</div>
            </div>
            <div class="col-sm-4">
                <div class="text-left text-sm-center m-1" id="shipment_fee_text">0.00</div>
            </div>
            <div class="col-sm-8">
                <div class="text-bold float-sm-right m-1">Total Payment</div>
            </div>
            <div class="col-sm-4">
                <div class="text-left text-sm-center m-1" id="shipment_fee_text">110.00</div>
            </div>
          </div>
        </div>
        
        <hr>
        <button class="btn btn-success float-right">Place Order</button>
    </div>
    
  <!-- /.content-wrapper -->

@include('footer')
@include('includes.modals')
<script src="{{asset('js/customer/checkout.js')}}"></script>
<script>
    $(document).ready(function() {
        let w = $('.responsive-img').width();
        $('.responsive-img').height(w); 
    });
</script>