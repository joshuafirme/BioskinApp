@extends('admin.manage-order.layout')

@section('content')

@php
    $page_title = "Bioskin | Manage Orders";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Manage Orders</h3>
          <hr>
      </div>

        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
    
                <li>{{$error}}</li>
                    
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12 col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                @php
                                    $pending_count = App\Models\Order::where('status', 1)->distinct()->count('order_id');
                                @endphp
                              <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">Pending <span class="badge badge-primary">{{$pending_count}}</span></a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="placed-tab" data-toggle="tab" href="#placed" role="tab" aria-controls="placed" aria-selected="false">Placed</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                <div class="mt-4">
                                    <table class="table table-hover" id="tbl-pending-order">
                                      <thead>
                                          <tr>
                                              <th>Order #</th>
                                              <th>Customer Name</th>
                                              <th>Email</th>
                                              <th>Phone number</th>
                                              <th>Date Order</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                  </table>
                                  </div>
                            </div>
                            <div class="tab-pane fade" id="placed" role="tabpanel" aria-labelledby="placed-tab">...</div>
                          </div>
                    </div>
                </div>
            </div>
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


    <!-- ORDER INFO MODAL -->
   
    <div class="modal fade bd-example-modal-lg" id="show-orders-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Order Information</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body" id="printable-order-info">
                  <div class="row" id="user-info">
                  </div>
                  <div class="mt-3 mb-3" id="shipping-info-container"></div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Variation</th>
                            <th>Size</th>
                            <th>Packaging</th>
                            <th>Closure</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="orders-container"></tbody>
                </table>
    
              </div>
              <div class="modal-footer">
              </div>
              <meta id="shipping-fee-value">
          </div>
        </div>
      </div>
@endsection