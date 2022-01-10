@php
  $page_title = "My Purchases | Bioskin";
  // read order details query              
  $order_detail = DB::table('order_details as OD')
    ->select('OD.*', 'OD.status', 'V.discount')
    ->where('order_id', $order_id)
    ->leftJoin('voucher as V', 'V.voucher_code', '=', 'OD.voucher_code')
    ->first();
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')

 <style>
   .border-md {
  border-width: 2px !important;
} 
.form-control::placeholder {
    color: #ccc;
    font-weight: bold;
    font-size: 0.9rem;
}
.form-control:focus {
    box-shadow: none;
}
  .form-control {
  border: 2px solid #d5dae2 !important;
  padding: 15px 25px !important;
  min-height: 45px !important;
  font-size: 13px !important; }
  .form-control::-webkit-input-placeholder {
    color: #919aa3; }
  .form-control::-moz-placeholder {
    color: #919aa3; }
  .form-control:-ms-input-placeholder {
    color: #919aa3; }
  .form-control::-ms-input-placeholder {
    color: #919aa3; }
  .form-control::placeholder {
    color: #919aa3; }
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

.table-container {
  background-color: #F5F5F5
}

.payment-method-container button, .row .btn{
    background-color: #F2F2F2;
    padding: 7px;
    border: 2px solid #E2E6EA !important;
    margin-bottom: 10px;
    color: #000;
  }

  .payment-method-container button {
      width: 150px;
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
    <div class="breadcrumb-container ml-2 mt-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/account')}}">Account</a></li>
            <li class="breadcrumb-item"><a href="{{url('/my-purchases?status=all')}}">My Purchases</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order ID {{ $order_id }}</li>
          </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-3 mb-3 mb-sm-0">
                <img src="https://img.icons8.com/color/50/000000/marker.png"/><span class="ml-1" style=""> Delivery Address</span>
            </div>
            <div class="col-sm-12 col-md-2">
                <div id="fullname">{{ isset($address->name) ? $address->name : "" }}
                </div>
                <div id="phone_no">{{ isset($address->phone_no) ? $address->phone_no : "" }}
                </div>
            </div>
            <div class="col-sm-12 col-md-5">
                <div id="address">{{ $address->municipality." ".$address->brgy ." ".$address->detailed_loc }}
                </div>
            </div>
              @php
                    $status = Utils::readStatusText($order_detail->status);
             
                    $payment_method_text = Utils::readPaymentMethodText($order_detail->payment_method);
              @endphp
            <div class="col-sm-12 col-md-2">
                <b>Order ID: {{$order_id}}</b>
                <span class="badge badge-success">{{ $status }}</span>
                <br><span class="badge badge-light">{{ $payment_method_text }}</span>
            </div>
        </div>
        <div>Remarks: {{ $order_detail->remarks }}</div>
        <div class="table-container mt-4 border mb-5">  
            <table class="table table-borderless" id="cart-table">
                <thead style="background-color: #E7E6E6;">
                    <th>Product Ordered</th>
                    <th>Item Description</th>
                    <th>Size</th>
                    <th>Variation</th>
                    <th>Packaging</th>
                    <th>Cap</th>
                    <th>Quantity</th>
                    <th>Order Subtotal</th>
                </thead>
                <tbody>
                  @php
                      $total = 0; 
                  @endphp
                  @foreach ($order_items as $key => $data)
                    <tr>
                      <td>
                        @php
                            $src = \DB::table('product_images')->where('sku', $item->sku)->value('image');
                            $total = $total + $data->amount;
                        @endphp
                        @if ($src)
                        <div class="responsive-img" style="width:70px; background-image:url('/images/{{ $src }}')"></div>
                        @else
                        <div class="responsive-img" style="width:70px; background-image: url('https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png')"></div>
                        @endif
                      </td>
                      <td>{{$data->name}}</td>
                      <td>{{$data->size ?$data->size : "-"}}</td>
                      <td>{{$data->variation ? $data->variation : "-"}}</td>
                      <td>{{$data->packaging ?$data->packaging : "-"}}</td>
                      <td>{{$data->closure ? $data->closure : "-"}}</td>
                      <td>{{$data->qty}}</td>
                      <td>₱{{number_format($data->amount,2,".",",")}}</td>
                    </tr> 
                  @endforeach
                    <tr>
                      <td colspan="3"></td>
                      <td colspan="5"><hr></td>
                    </tr> 
                    <tr>
                      <td colspan="6"></td>
                      <td>Merchandise subtotal</td>
                      <td><b>₱{{number_format($total,2,".",",")}}</b></td>
                    </tr> 
                    <tr>
                      <td colspan="6"></td>
                      <td>Voucher discount</td>
                      <td><b>₱{{number_format($order_detail->discount,2,".",",")}}</b></td>
                    </tr>
                    @php
                        $total = $total - $order_detail->discount;
                    @endphp
                    <tr>
                      <td colspan="6"></td>
                      <td>Total Payment</td>
                      <td><b>₱{{number_format($total,2,".",",")}}</b>
                          <br>
                          @if(empty($order_detail->expiry_date) && $order_detail->status == 0)
                            <button class="btn btn-success mt-2" id="btn-pay-now" 
                              data-order-id="{{$order_id}}" data-pay-now="true" data-expiry-date="{{$order_detail->expiry_date}}"
                              data-pmethod="{{$order_detail->payment_method}}" data-voucher-code="{{$order_detail->voucher_code}}">
                              Pay now
                            </button>
                            @else
                            @endif
                      </td>
                    </tr> 
                    
                </tbody>
            </table>  
            
            <small class="m-2 float-lg-right">
              @php
                  $expiry_date = date("Y-m-d H:i:s", strtotime($order_detail->created_at." + 2 days"))
              @endphp
              @if (Utils::isValidForPayment($expiry_date) && $order_detail->expiry_date) 
              You have until {{ date('F d, Y H:i:s a', strtotime($expiry_date)) }} to make the payment.
              <br>
              @endif
              *Shipping fee not included, please wait for our logistics team to contact you with regard to the cost</small>
        </div>
        <div id="paynamics-form-container" class="mb-5"></div>
    </div>

   </div>
    
  <!-- /.content-wrapper -->

@include('footer')
@include('includes.modals')

<script>
    $(document).ready(function() {
        let w = $('.responsive-img').width();
        $('.responsive-img').height(w); 

        function paynamicsPayment(order_id, pay_now, pmethod) {
            $.ajax({
                url: '/paynamics-payment',
                type: 'POST',
                data: {
                  order_id : order_id,
                  pay_now : pay_now,
                  pmethod : pmethod
                },
                success:function(data){
                    console.log(data)
                    $('#paynamics-form-container').html(data);
                }
            });
        }

        $(document).on('click','#btn-pay-now', function(){
            var btn = $(this);
            var id = $(this).attr('data-id');
            var order_id = $(this).attr('data-order-id');
            var pmethod = $(this).attr('data-pmethod');
            var pay_now = $(this).attr('data-pay-now');
            btn.html('<i class="fas fa-spinner fa-pulse"></i>');
   
            paynamicsPayment(order_id, pay_now, pmethod);
            
        });
    });
</script>