@php
  $page_title = "Checkout | Bioskin";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <style>.border-md {
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
      border: 2px solid #d5dae2;
      padding: 15px 25px;
      min-height: 45px;
      font-size: 13px; }
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
            <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>
            <li class="breadcrumb-item"><a href="{{url('/cart')}}">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
          </ol>
        </nav>
    </div>

    <h3 class="text-center text-bold">Checkout</h3>
    <div class="container card delivery-address-container">
        <div class="row ">
            <div class="col-sm-12 col-md-3">
                <img src="https://img.icons8.com/color/50/000000/marker.png"/><span class="ml-1" style=""> Delivery Address</span>
            </div>
            <div class="col-sm-12 col-md-2">
                <div id="fullname">
                </div>
                <div id="phone_no">
                </div>
            </div>
            <div class="col-sm-12 col-md-5">
                <div id="address">
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <button class="btn btn-secondary m-1 float-none float-md-right" id="btn-set-default">Default</button>
                <button class="btn btn-secondary m-1 float-none float-md-right" id="btn-change-address" data-toggle="modal" data-target="#checkout-address-modal">Change</button>
            </div>
        </div>
    </div>
    <div class=" table-container" >  
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
    <div class="">
      <hr>
      <div class="row">
        <div class="col-sm-3">
            <textarea class="form-control" id="notes" rows="4" placeholder="Leave a message (Optional)"></textarea>
        </div>
        <div class="col-sm-6">
            <div class="p-1">
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
                    <div class="col-sm-12 col-md-4">
                        <div class="btn btn-sm btn-secondary m-2" id="btn-change-courier" data-toggle="modal" data-target="#courier-modal">Change courier</div>
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
    <div class="" style="margin-bottom: 200px;">
        <hr>
        <div class="row">
          <div class="col-sm-3 text-center payment-method-container">
              <p class="text-bold">Payment Method</p>
              <div><button class="btn btn-secondary">Credit/Debit Card</button></div>
              <div><button class="btn btn-secondary">Online Payment</button></div>
              <div><button class="btn btn-secondary" data-value="cod">Cash on Delivery</button></div>
          </div>
          <div class="col-sm-9 row">
            <div class="col-sm-8">
                <div class="p-1">
                    <div class="text-center text-bold p-2" style="background-color: #F4F4F4;">Vouchers</div>
                    <div class="row">
                      <div class="col-sm-12 col-md-6">
                        <form>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fas fa-gift text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" id="voucher" class="form-control bg-white border-left-0 border-md" placeholder="Enter voucher code">
                            </div>
                            <div id="voucher-validation"></div>
                        </form>
                      </div>
                      <div class="col-sm-12 col-md-6">
                        <div class="btn btn-sm btn-secondary mt-3" id="btn-select-voucher" data-toggle="modal" data-target="#voucher-modal">Select Voucher</div>
                      </div>
                  </div>  
                </div>
            </div>
            <div class="col-sm-4">
                <div class="text-bold mt-4 text-center">Voucher Discount</div>
                <div class="text-center voucher_discount_text">0.00</div>
            </div>
            <div class="col-sm-12">
               <hr>
            </div>
            <div class="col-sm-8">
                <div class="text-bold float-sm-right m-1">Merchandise Subtotal</div>
            </div>
            <div class="col-sm-4">
                <div class="text-left text-sm-right m-1" id="merchant_total_text">₱{{number_format($total,2,".",",")}}</div>
            </div>
            <div class="col-sm-8">
                <div class="text-bold float-sm-right m-1">Shipping Total</div>
            </div>
            <div class="col-sm-4">
                <div class="text-left text-sm-right m-1" id="shipment_fee_text">0.00</div>
            </div>
            <div class="col-sm-8">
                <div class="text-bold float-sm-right m-1">Voucher Discount</div>
            </div>
            <div class="col-sm-4">
                <div class="text-left text-sm-right m-1">- <span class="voucher_discount_text">0.00</span></div>
            </div>
            <div class="col-sm-8">
                <div class="text-bold float-sm-right m-1">Total Payment</div>
            </div>
            <div class="col-sm-4">
                <div class="text-left text-sm-right m-1">₱<span id="total_payment_text">{{number_format($total,2,".",",")}}</span></div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row mt-2">
           <div class="col-sm-12">
            <div class="float-right">
                <div id="input-validation"></div>
                @if (count($cart) > 0) 
                <button class="btn btn-secondary text-bold float-right" id="btn-place-order">Place Order</button></div>
                @endif
                @php
                    $_mid = "000000201221F7E57B0B"; 
                    $_requestid = substr(uniqid(), 0, 13);
                    $_responseid = rand(9,100);
                    $_ipaddress = '136.158.17.242';
                    $_noturl = route('paynamics'); 
                    $_resurl = route('paynamics'); 
                    $_cancelurl = "http://127.0.0.1:8000/checkout"; 
                    $_fname = "Sandy"; 
                    $_mname = "C"; 
                    $_lname = "Cruz"; 
                    $_addr1 = "Nasugbu Batangas"; 
                    $_addr2 = "Batangas City";
                    $_city = "Batangas"; 
                    $_state = "PH"; 
                    $_country = "PH"; 
                    $_zip = "4231"; 
                    $_sec3d = "try3d";  
                    $_email = "technical@paynamics.net";
                    $_phone = "3308772"; 
                    $_mobile = "09178134828"; 
                    $_clientip = $_SERVER['REMOTE_ADDR'];
                    $_amount = 100.00; 
                    $_currency = "PHP"; 
                    $mkey = "35440C9612BDA6F568EAA9A5BA7A6BEA";

                    $forSign = $_mid . 
                            $_requestid . 
                            $_ipaddress . 
                            $_noturl . 
                            $_resurl .  
                            $_fname . 
                            $_lname . 
                            $_mname . 
                            $_addr1 . 
                            $_addr2 . 
                            $_city . 
                            $_state . 
                            $_country . 
                            $_zip . 
                            $_email . 
                            $_mobile . 
                            $_clientip . 
                            $_amount . 
                            $_currency . 
                            $_sec3d . 
                            $mkey;

                    $_sign = hash("sha512", $forSign);
                    
                    $strxml = "";
                    $strxml .= "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
                    $strxml .= "<Request>";
                        $strxml .= "<orders>";
                            $strxml .= "<items>";
                                // item 1
                                $strxml .= "<Items>";
                                    $strxml .= "<itemname>item 1</itemname>";
                                    $strxml .= "<quantity >1</quantity>";
                                    $strxml .= "<amount >".$_amount ."</amount>";
                                $strxml .= "</Items>";
                            $strxml .= "</items>";
                        $strxml .= "</orders>";
                        $strxml .= "<mid>" . $_mid . "</mid>";
                        $strxml .= "<request_id>" . $_requestid . "</request_id>";
                        $strxml .= "<ip_address>" . $_ipaddress . "</ip_address>";
                        $strxml .= "<notification_url>" . $_noturl . "</notification_url>";
                        $strxml .= "<response_url>" . $_resurl . "</response_url>";
                        $strxml .= "<cancel_url>" . $_cancelurl . "</cancel_url>";
                        $strxml .= "<mtac_url>".$_resurl."</mtac_url>"; // pls set this to the url where your terms and conditions are hosted
                        $strxml .= "<descriptor_note>test</descriptor_note>"; // pls set this to the descriptor of the merchant ""
                        $strxml .= "<fname>" . $_fname . "</fname>";
                        $strxml .= "<lname>" . $_lname . "</lname>";
                        $strxml .= "<mname>" . $_mname . "</mname>";
                        $strxml .= "<address1>" . $_addr1 . "</address1>";
                        $strxml .= "<address2>" . $_addr2 . "</address2>";
                        $strxml .= "<city>" . $_city . "</city>";
                        $strxml .= "<state>" . $_state . "</state>";
                        $strxml .= "<country>" . $_country . "</country>";
                        $strxml .= "<zip>" . $_zip . "</zip>";
                        $strxml .= "<secure3d>" . $_sec3d . "</secure3d>";
                        $strxml .= "<trxtype>authorized</trxtype>";
                        $strxml .= "<email>" . $_email . "</email>";
                        $strxml .= "<phone>" . $_phone . "</phone>";
                        $strxml .= "<mobile>" . $_mobile . "</mobile>";
                        $strxml .= "<amount >" . $_amount . "</amount>";
                        $strxml .= "<currency>" . $_currency . "</currency>";
                        $strxml .= "<expiry_limit></expiry_limit>";
                        $strxml .= "<client_ip>" . $_clientip . "</client_ip>";
                        $strxml .= "<mlogo_url>https://gmalcilk.sirv.com/c084d2e12ec5d8f32f6fa5f16b76d001.jpeg</mlogo_url>";// pls set this to the url where your logo is hosted
                        $strxml .= "<pmethod></pmethod>";
                        $strxml .= "<signature>". $_sign ."</signature>";
                        $strxml .= "</Request>";
                    
                        $b64string = base64_encode($strxml);
                @endphp
                <form name="surecollect" id="surecollect" method="post" action="https://testpti.payserv.net/webpayment/Default.aspx">
                    @csrf
                    <input type="hidden" name="paymentrequest" value="{{$b64string}}">
                    <button type="submit" class="btn btn-secondary text-bold float-right">Paynamics</button></div>
                </form>
           </div>
        </div>
    </div>
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