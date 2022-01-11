@php
$page_title = 'Checkout | Bioskin';
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

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
        border: 2px solid #d5dae2;
        padding: 15px 25px;
        min-height: 45px;
        font-size: 13px;
    }

    .form-control::-webkit-input-placeholder {
        color: #919aa3;
    }

    .form-control::-moz-placeholder {
        color: #919aa3;
    }

    .form-control:-ms-input-placeholder {
        color: #919aa3;
    }

    .form-control::-ms-input-placeholder {
        color: #919aa3;
    }

    .form-control::placeholder {
        color: #919aa3;
    }

    .card {
        background-color: #F4F4F4;
        padding: 10px;
    }

    table {
        border-collapse: collapse !important;
    }

    .table-container {
        overflow-x: auto;
    }

    th,
    td {
        padding: 10px !important;
    }

    td {
        padding: 10px !important;
        margin: 0 !important;
    }

    thead {
        position: sticky !important;
        top: 0 !important;
        background-color: #FFF;
        border-color: #C4BFC2;
        z-index: 999;
    }

    .btn-grey {
        background-color: #F2F2F2;
        padding: 7px;
        border: 2px solid #E2E6EA !important;
        margin-bottom: 10px;
        color: #000;
    }

    .payment-method-container button {
        border: 1px solid #D9D9D9;
        margin-bottom: 10px;
        height: 50px;
    }

    .payment-method-container .active {
        border: 1px solid #00AD35;
        background-color: #EFF6EC !important;
    }

    .fa-check-circle {
        margin-top: 3px;
        color: #00AD35;
    }

    .fa-circle {
        margin-top: 3px;
        color: #BFBFBF;
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

    <div class="row pl-3 pr-3 pt-1 pb-1 justify-content-center" style="margin-top: 11px; background-color: #EFF6EC;">
        @php
            $categories = Utils::readCategories();
        @endphp
        @foreach ($categories as $item)

            <a class="p-1 ml-3 mr-3 text-center" href="{{ url('/shop/category/' . $item->id) }}">
                <div class="text-muted category-name" data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                    {{ $item->name }}</div>
            </a>
        @endforeach
    </div>

    <div class="container">
        <div class="breadcrumb-container ml-2 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/cart') }}">Cart</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>

        <h3 class="text-center text-bold">Checkout</h3>
        <div class="container card delivery-address-container">
            <!-- set default address value -->
            <input type="hidden" id="address_id" value="{{ isset($address->id) ? $address->id : '' }}">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <img src="https://img.icons8.com/color/50/000000/marker.png" /><span class="ml-1"
                        style=""> Delivery Address</span>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div id="fullname">{{ isset($address->fullname) ? $address->fullname : '' }}</div>
                    <div id="phone_no">{{ isset($address->phone_no) ? $address->phone_no : '' }}</div>
                </div>
                <div class="col-sm-12 col-md-5">
                    <div id="address">
                        {{ isset($address) && $address ? Utils::concatAddress($address) : '' }} <br>
                        {{ isset($address->notes) ? $address->notes : '' }}
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <button class="btn btn-secondary btn-grey m-1 float-none float-md-right"
                        id="btn-set-default">Default</button>
                    <button class="btn btn-secondary btn-grey m-1 float-none float-md-right" id="btn-change-address"
                        data-toggle="modal" data-target="#checkout-address-modal">Change</button>
                </div>
            </div>
        </div>
        <div class=" table-container">
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
                            $src = \DB::table('product_images')
                                ->where('sku', $item->sku)
                                ->value('image');
                        @endphp
                        <tr>
                            <td>
                                @if ($src)
                                    <div class="responsive-img"
                                        style="width:100px; background-image:url('/images/{{ $src }}')"></div>
                                @else
                                    <div class="responsive-img"
                                        style="width:100px; background-image: url('https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png')">
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->size ? $item->size : '-' }}</td>
                            <td>{{ $item->variation ? $item->variation : '-' }}</td>
                            <td>{{ $item->packaging ? $item->packaging : '-' }}</td>
                            <td>{{ $item->closure ? $item->closure : '-' }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>₱{{ number_format($item->amount, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="">
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <textarea class="form-control" id="notes" rows="4"
                        placeholder="Leave a message (Optional)"></textarea>
                </div>
                <div class="col-sm-9">
                    <div class="p-1">
                        <div class="text-center text-bold p-2" style="background-color: #F4F4F4;">Shipping Option</div>
                        <div class="row">
                            @php
                                $courier = App\Models\Courier::where('status', 1)->first();
                            @endphp
                            <div class="col-sm-12 col-md-4">
                                <div class="text-center p-2 mt-2" style="background-color: #F4F4F4;">
                                    <input type="hidden" id="courier_id" value="{{ $courier->id }}">
                                    <img
                                        src="https://img.icons8.com/external-vitaliy-gorbachev-flat-vitaly-gorbachev/25/000000/external-courier-sales-vitaliy-gorbachev-flat-vitaly-gorbachev.png" />
                                    <span class="ml-2"
                                        id="courier_text">{{ isset($courier->name) ? $courier->name : '' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="btn btn-sm btn-secondary btn-grey m-2" id="btn-change-courier"
                                    data-toggle="modal" data-target="#courier-modal">Change courier</div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="text-bold mt-2">Receive by</div>
                                <div id="receive_by_text">
                                    {{ isset($courier->receive_by) ? $courier->receive_by : '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="" style="margin-bottom: 200px;">
            <hr>
            <div class="row">
                <div class="col-sm-3 text-center payment-method-container">
                    <p class="text-bold">Select Payment Method</p>
                    <div><button class="btn active btn-block" data-value="COD">Cash on Delivery <i
                                class="fas fa-check-circle float-right"></i></button></div>
                    <div><button class="btn btn-block" data-value="online_payment">Online Payment <i
                                class="far fa-circle float-right"></i></button></div>
                </div>
                <div class="col-sm-9 payment-methods-container d-none">

                    <div class="mb-4 border p-3">
                        <div class="row mb-3">
                            <div id="pm_cc" class="col-md-6 col-lg-4 col-xs-12 mt-3" style="display:block;">
                                <div class="custom-control custom-radio">
                                    <input value="cc" name="rad_pm" type="radio" id="rad_cc"
                                        class="custom-control-input" checked>
                                    <label class="custom-control-label text-md-left" for="rad_cc">
                                        <span class="pm-icon-holder">
                                            <img style="margin-top: -12px;"
                                                src="https://img.icons8.com/external-vitaliy-gorbachev-flat-vitaly-gorbachev/51/000000/external-credit-card-ecommerce-vitaliy-gorbachev-flat-vitaly-gorbachev.png" />
                                        </span>
                                        &nbsp;
                                        <span class="text-prussian-blue font-weight-bold small">Credit / Debit
                                            Card</span>
                                    </label>
                                </div>
                            </div>
                            <div id="pm_cc" class="col-md-6 col-lg-4 col-xs-12 mt-3" style="display:block;">
                                <div class="custom-control custom-radio">
                                    <input value="gc" name="rad_pm" type="radio" id="rad_gcash"
                                        class="custom-control-input">
                                    <label class="custom-control-label text-md-left" for="rad_gcash">
                                        <span class="pm-icon-holder">
                                            <img style="border-radius:5px; margin-top: -9px;" width="51"
                                                src="https://logos-download.com/wp-content/uploads/2020/06/GCash_Logo.png" />
                                        </span>
                                        &nbsp;
                                        <span class="text-prussian-blue font-weight-bold small">GCash e-wallet</span>
                                    </label>
                                </div>
                            </div>
                            <div id="pm_cc" class="col-md-6 col-lg-4 col-xs-12 mt-3" style="display:block;">
                                <div class="custom-control custom-radio">
                                    <input value="bpionline" name="rad_pm" type="radio" id="rad_bpi"
                                        class="custom-control-input">
                                    <label class="custom-control-label text-md-left" for="rad_bpi">
                                        <span class="pm-icon-holder">
                                            <img style="border-radius:5px; margin-top: -12px;" class="bg-white"
                                                width="51" src="" />
                                        </span>
                                        &nbsp;
                                        <span class="text-prussian-blue font-weight-bold small">BPI Online</span>
                                    </label>
                                </div>
                            </div>
                            <div id="pm_cc" class="col-md-6 col-lg-4 col-xs-12 mt-3" style="display:block;">
                                <div class="custom-control custom-radio">
                                    <input value="br_bdo_ph" name="rad_pm" type="radio" id="rad_bdo"
                                        class="custom-control-input">
                                    <label class="custom-control-label text-md-left" for="rad_bdo">
                                        <span class="pm-icon-holder">
                                            <img style="" class="bg-white" width="51"
                                                src="https://gmalcilk.sirv.com/bdo_logo.png" />
                                        </span>
                                        &nbsp;
                                        <span class="text-prussian-blue font-weight-bold small">BDO Online via
                                            Brankas</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!--  <div class="mb-1"><b>Over the Counter Payments</b></div>
             <div class="row">
                <div id="pm_ceb" class="col-md-6 col-xs-12" style="display:block;">
                    <div class="custom-control custom-radio">
                        <input value="ceb" name="rad_pm" type="radio" id="rad_ceb" class="custom-control-input">
                        <label class="custom-control-label text-md-left" for="rad_ceb">
                            <span class="pm-icon-holder">
                                <img src="https://testpti.payserv.net/webpayment/resources/images/otc-icons/ceb.png" alt="Cebuana Lhuillier">
                            </span>
                            &nbsp;
                        <span class="text-prussian-blue font-weight-bold small">Cebuana Lhuillier</span>
                        </label>
                        <br>
                        <span class="small text-blueberry">Pay in cash at for your online purchase any Cebuana Lhuillier branch.</span>
                    </div>
                </div>
                <div id="pm_seveneleven" class="col-md-6 col-xs-12" style="display:block;">
                    <div class="custom-control custom-radio">
                        <input value="7eleven" name="rad_pm" type="radio" id="rad_seveneleven" class="custom-control-input">
                        <label class="custom-control-label text-md-left" for="rad_seveneleven">
                            <span class="pm-icon-holder">
                                <img src="https://testpti.payserv.net/webpayment/resources/images/otc-icons/7connect.png" alt="7-Eleven">
                            </span>
                            &nbsp;
        <span class="text-prussian-blue font-weight-bold small">7-Eleven</span>
                        </label>
                        <br>
                        <span class="small text-blueberry">Pay in cash for your online purchase at any 7-Eleven store.</span>
                    </div>
                </div>
                <div id="pm_ecpay" class="col-md-6 col-xs-12" style="display:block;">
                    <div class="custom-control custom-radio">
                        <input value="ecpay" name="rad_pm" type="radio" id="rad_ecpay" class="custom-control-input">
                        <label class="custom-control-label text-md-left" for="rad_ecpay">
                            <span class="pm-icon-holder">
                                <img src="https://testpti.payserv.net/webpayment/resources/images/otc-icons/ecpay.png" alt="ECPay">
                            </span>
                            &nbsp;
        <span class="text-prussian-blue font-weight-bold small">ECPay</span>
                        </label>
                        <br>
                        <span class="small text-blueberry">Pay in cash for your online purchase at any ECPay accredited store.</span>
                    </div>
                </div>
                <div id="pm_cliqq" class="col-md-6 col-xs-12" style="display:block;">
                    <div class="custom-control custom-radio">
                        <input value="cliqq" name="rad_pm" type="radio" id="rad_cliqq" class="custom-control-input">
                        <label class="custom-control-label text-md-left" for="rad_cliqq">
                            <span class="pm-icon-holder">
                                <img src="https://testpti.payserv.net/webpayment/resources/images/otc-icons/cliqq.png" alt="Cliqq">
                            </span>
                            &nbsp;
        <span class="text-prussian-blue font-weight-bold small">CLiQQ</span>
                        </label>
                        <br>
                        <span class="small text-blueberry">Pay in cash for your online purchase at any (7-Eleven) CLiQQ touchscreen payment kiosk.</span>
                    </div>
                </div>
                <div id="pm_ml" class="col-md-6 col-xs-12" style="display:block;">
                    <div class="custom-control custom-radio">
                        <input value="ml" name="rad_pm" type="radio" id="rad_ml" class="custom-control-input">
                        <label class="custom-control-label text-md-left" for="rad_ml">
                            <span class="pm-icon-holder">
                                <img src="https://testpti.payserv.net/webpayment/resources/images/otc-icons/ml.png" alt="M Lhuillier">
                            </span>
                            &nbsp;
        <span class="text-prussian-blue font-weight-bold small">M Lhuillier</span>
                        </label>
                        <br>
                        <span class="small text-blueberry">Pay in cash for your online purchase at any MLhuillier branch.</span>
                    </div>
                </div>
                <div id="pm_bayadcenter" class="col-md-6 col-xs-12" style="display: none">
                    <div class="custom-control custom-radio">
                        <input value="bayadcenter" name="rad_pm" type="radio" id="rad_bayadcenter" class="custom-control-input">
                        <label class="custom-control-label text-md-left" for="rad_bayadcenter">
                            <span class="pm-icon-holder">
                                <img src="https://testpti.payserv.net/webpayment/resources/images/otc-icons/bayadcenter.png" alt="BayadCenter">
                            </span>
                            &nbsp;
        <span class="text-prussian-blue font-weight-bold small">Bayad Center</span>
                        </label>
                        <br>
                        <span class="small text-blueberry">Pay in cash for your online purchase at Bayad Center branches.</span>
                    </div>
                </div>
                <div id="pm_bdootc" class="col-md-6 col-xs-12" style="display:block;">
                    <div class="custom-control custom-radio">
                        <input value="bdootc" name="rad_pm" type="radio" id="rad_bdootc" class="custom-control-input">
                        <label class="custom-control-label text-md-left" for="rad_bdootc">
                            <span class="pm-icon-holder">
                                <img src="https://testpti.payserv.net/webpayment/resources/images/otc-icons/bdootc.png" alt="BDO">
                            </span>
                            &nbsp;
        <span class="text-prussian-blue font-weight-bold small">BDO</span>
                        </label>
                        <br>
                        <span class="small text-blueberry">To pay for your online purchase, go to the nearest BDO branch.</span>
                    </div>
                </div>
            </div>-->
                    </div>
                </div>
                <div class="col-sm-9 row computation-container">
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
                                            <input type="text" id="voucher"
                                                class="form-control bg-white border-left-0 border-md"
                                                placeholder="Enter voucher code">
                                        </div>
                                        <div id="voucher-validation"></div>
                                    </form>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="btn btn-sm btn-secondary btn-grey mt-3" id="btn-select-voucher"
                                        data-toggle="modal" data-target="#voucher-modal">Select Voucher</div>
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
                        <div class="text-left text-sm-right m-1" id="merchant_total_text">
                            ₱{{ number_format($total, 2, '.', ',') }}</div>
                    </div>
                    <!--   <div class="col-sm-8">
                <div class="text-bold float-sm-right m-1">Shipping Total</div>
            </div>
            <div class="col-sm-4">
                <div class="text-left text-sm-right m-1" id="shipment_fee_text">0.00</div>
            </div>-->
                    <div class="col-sm-8">
                        <div class="text-bold float-sm-right m-1">Voucher Discount</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-left text-sm-right m-1">- <span class="voucher_discount_text">0.00</span>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-bold float-sm-right m-1">Total Payment</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-left text-sm-right m-1">₱<span
                                id="total_payment_text">{{ number_format($total, 2, '.', ',') }}</span></div>
                    </div>
                    <div class="col-12 mt-1">
                        <small class="float-right">*Shipping fee not included, please wait for our logistics team to
                            contact you with regard to the cost</small>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12">
                    <div class="float-right">
                        <div id="input-validation"></div>
                        @if (count($cart) > 0)
                            <button class="btn btn-secondary btn-grey text-bold float-right" id="btn-place-order">Place
                                Order</button>
                    </div>
                    @endif
                </div>
            </div>
            <div id="paynamics-form-container"></div>
        </div>
    </div>

    <!-- /.content-wrapper -->

    @include('footer')
    @include('includes.modals')
    <script src="{{ asset('js/customer/checkout.js') }}"></script>
    <script>
        $(document).ready(function() {
            let w = $('.responsive-img').width();
            $('.responsive-img').height(w);
        });
    </script>
