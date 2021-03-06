@php
$page_title = 'My Purchases | Bioskin';
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
        border: 2px solid #d5dae2 !important;
        padding: 15px 25px !important;
        min-height: 45px !important;
        font-size: 13px !important;
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

    .table-container {
        background-color: #F5F5F5
    }

    .payment-method-container button,
    .row .btn {
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
                    <div></div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="row pl-3 pr-3 pt-1 pb-1 justify-content-center" style="margin-top: 11px; background-color: #EFF6EC;">
        @php
            if (\Cache::get('categories-cache')) {
                $cache_categories = \Cache::get('categories-cache');
            } else {
                $cache_categories = \App\Models\Category::where('status', 1)->get();
            }
        @endphp
        @foreach ($cache_categories as $item)

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
                    <li class="breadcrumb-item"><a href="{{ url('/account') }}">Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Purchases</li>
                </ol>
            </nav>
        </div>
        <div class="container">
            <div class="row ">
                <div class="col-sm-12">
                    <form id="form-search-order">
                        <input class="form-control float-right w-50" id="search-order" type="search"
                            placeholder="Search by Order ID or Product Name" aria-label="Search">
                    </form>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="row mb-3">
                        <div class="col-2 col-sm-3">
                            @php
                                $user = \Auth::user();
                                
                                $status = isset($_GET['status']) ? $_GET['status'] : '';

                                if (isset($_GET['key'])) {
                                    $my_orders = \App\Models\Order::select('orders.order_id', 'orders.created_at', 'OD.status')
                                    ->leftJoin('order_details as OD', 'OD.order_id', '=', 'orders.order_id')
                                    ->leftJoin('products as P', 'P.sku', '=', 'orders.sku')
                                    ->where('user_id', Auth::id())
                                    ->where('orders.order_id', 'LIKE', "%".$_GET['key']."%")
                                    ->orWhere('P.name', 'LIKE', "%".$_GET['key']."%")
                                    ->orderBy('orders.created_at', 'desc')
                                    ->distinct('orders.order_id')
                                    ->paginate(5);
                                } 
                                else {
                                    // if status is to receive, display order received as well
                                    $status_order_received = $status == 3 ? 6 : -1;
                                    $status_arr = [$status, $status_order_received];
                                    $my_orders = \App\Models\Order::select('orders.order_id', 'orders.created_at', 'OD.status')
                                    ->where('user_id', Auth::id())
                                    ->whereIn('OD.status', $status_arr)
                                    ->leftJoin('order_details as OD', 'OD.order_id', '=', 'orders.order_id')
                                    ->orderBy('orders.created_at', 'desc')
                                    ->distinct('orders.order_id')
                                    ->paginate(5);

                                    if ($status == 'all' || !isset($_GET['status'])) {
                                        $my_orders = \App\Models\Order::select('orders.order_id', 'orders.created_at', 'OD.status')
                                            ->where('user_id', Auth::id())
                                            ->leftJoin('order_details as OD', 'OD.order_id', '=', 'orders.order_id')
                                            ->orderBy('orders.created_at', 'desc')
                                            ->distinct('orders.order_id')
                                            ->paginate(3);
                                    }  
                                }
                                 
                                
                                $to_pay_count = $order_mdl->countOrderByStatus(0);
                                $processing_count = $order_mdl->countOrderByStatus(1);
                                $otw_count = $order_mdl->countOrderByStatus(2);
                                $to_receive_count = $order_mdl->countOrderByStatus(3);
                                $completed_count = $order_mdl->countOrderByStatus(4);
                                $cancelled_count = $order_mdl->countOrderByStatus(5);
                                $all_count = \App\Models\Order::where('user_id', Auth::id())
                                    ->leftJoin('order_details as OD', 'OD.order_id', '=', 'orders.order_id')
                                    ->distinct('orders.order_id')
                                    ->count('OD.id');
                                
                            @endphp
                            @if ($user->image)
                                <img class="img-thumbnail rounded-circle" width="75px"
                                    src="{{ asset('/images/' . $user->image) }}" />
                            @else
                                <img src="https://img.icons8.com/small/75/000000/user-male-circle.png" />
                            @endif
                        </div>
                        <div class="col-9">
                            <div class="mt-1 text-bold">
                                {{ $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname }}</div>
                            <div>{{ $user->phone_no }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9">
                    <ul class="nav nav-pills mb-3 mt-3 float-right" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $status == 'all' ? 'active' : '' }}"
                                href="{{ url('/my-purchases?status=all') }}">All <span
                                    class="badge">{{ $all_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == '0' ? 'active' : '' }}"
                                href="{{ url('/my-purchases?status=0') }}">To pay <span
                                    class="badge">{{ $to_pay_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == '1' ? 'active' : '' }}"
                                href="{{ url('/my-purchases?status=1') }}">Processing <span
                                    class="badge">{{ $processing_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == '2' ? 'active' : '' }}"
                                href="{{ url('/my-purchases?status=2') }}">On the way <span
                                    class="badge">{{ $otw_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == '3' ? 'active' : '' }}"
                                href="{{ url('/my-purchases?status=3') }}">To receive <span
                                    class="badge">{{ $to_receive_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == '4' ? 'active' : '' }}"
                                href="{{ url('/my-purchases?status=4') }}">Completed <span
                                    class="badge">{{ $completed_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == '5' ? 'active' : '' }}"
                                href="{{ url('/my-purchases?status=5') }}">Cancelled <span
                                    class="badge">{{ $cancelled_count }}</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                    @if (count($my_orders) > 0)
                        @foreach ($my_orders as $item)
                            <div class="table-container mt-3 border ">
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
                                            $order_items = $order_mdl->readOrdersByOrderIDAndStatus($item->order_id);
                                            $total = 0;
                                        @endphp
                                        @foreach ($order_items as $key => $data)
                                            <tr>
                                                <td>
                                                    @php
                                                        $src = \DB::table('product_images')
                                                            ->where('sku', $item->sku)
                                                            ->value('image');
                                                        $total = $total + $data->amount;
                                                        
                                                        $status = Utils::readStatusText($data->status);
                                                    @endphp
                                                    @if ($src)
                                                        <div class="responsive-img"
                                                            style="width:70px; background-image:url('/images/{{ $src }}')">
                                                        </div>
                                                    @else
                                                        <div class="responsive-img"
                                                            style="width:70px; background-image: url('https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png')">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->size ? $data->size : '-' }}</td>
                                                <td>{{ $data->variation ? $data->variation : '-' }}</td>
                                                <td>{{ $product->readPackagingNameByID($data->packaging_sku) }}</td>
                                                <td>{{ $product->readPackagingNameByID($data->cap_sku) }}</td>
                                                <td>{{ $data->qty }}</td>
                                                <td>???{{ number_format($data->amount, 2, '.', ',') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="5">
                                                <hr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"><a class="text-dark"
                                                    href="{{ url('/my-purchase/' . $item->order_id) }}"><b>Order ID:
                                                        {{ $item->order_id }}</b></a><span
                                                    class="badge badge-{{ $item->status == 5 ? "danger" : "success" }} ml-3"> {{ $status }}</span> <br>
                                                    Order placed: {{date('F d, Y h:i A', strtotime($item->created_at))}}
                                                <br><span><a href="{{ url('/my-purchase/' . $item->order_id) }}">View
                                                        more details</a></span>
                                            </td>
                                            <td>Total Amount</td>
                                            <td><b>???{{ number_format($total, 2, '.', ',') }}</b></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-secondary text-center">No order was found.</div>
                    @endif

                    <div class="mt-3">
                        {{ $my_orders->appends(request()->except('page'))->links() }}
                    </div>

                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...
                </div>
            </div>

        </div>

    </div>

    <!-- /.content-wrapper -->

    @include('footer')
    @include('includes.modals')
    <script>
        $(document).ready(function() {
            let w = $('.responsive-img').width();
            $('.responsive-img').height(w);

            $(document).on('submit','#form-search-order', function(e){
                e.preventDefault();
                let key = $('#search-order').val();
               // let url = new URL(window.location);
               // let status = url.searchParams.get("status");
                window.location.href = "/my-purchases?key="+key;
            });
           
        });
    </script>
