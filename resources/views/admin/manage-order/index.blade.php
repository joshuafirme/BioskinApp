@extends('admin.manage-order.layout')

@section('content')

<style>
  .nav-link.active {
    color: #FFF !important;
  }
  .nav-tabs .nav-link {
    color: #00AD35;
  }
</style>

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
                            <a class="nav-link" id="to-pay-tab" data-toggle="tab" href="#to-pay" role="tab" aria-controls="to-pay" aria-selected="false">To pay</a>
                          </li>
                            <li class="nav-item">
                                @php
                                    $processing_count = App\Models\Order::where('status', 1)->distinct()->count('order_id');
                                @endphp
                              <a class="nav-link active" id="processing-tab" data-toggle="tab" href="#processing" role="tab" aria-controls="processing" aria-selected="true">Processing <span class="badge badge-primary">{{$processing_count}}</span></a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="otw-tab" data-toggle="tab" href="#otw" role="tab" aria-controls="otw" aria-selected="false">On the way</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="to-receive-tab" data-toggle="tab" href="#to-receive" role="tab" aria-controls="to-receive" aria-selected="false">To receive</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="received-tab" data-toggle="tab" href="#received" role="tab" aria-controls="received" aria-selected="false">Order received</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show" id="to-pay" role="tabpanel" aria-labelledby="to-pay-tab">
                              <div class="mt-4">
                                  <table class="table table-hover" id="tbl-to-pay-order">
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
                            <div class="tab-pane fade show active" id="processing" role="tabpanel" aria-labelledby="processing-tab">
                                <div class="mt-4">
                                    <table class="table table-hover" id="tbl-processing-order">
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
                            <div class="tab-pane fade" id="otw" role="tabpanel" aria-labelledby="otw-tab">
                              <div class="mt-4">
                                <table class="table table-hover" id="tbl-otw-order">
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
                            <div class="tab-pane fade" id="to-receive" role="tabpanel" aria-labelledby="to-receive-tab">
                              <div class="mt-4">
                                <table class="table table-hover" id="tbl-to-receive-order">
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
                            <div class="tab-pane fade" id="received" role="tabpanel" aria-labelledby="received-tab">
                              <div class="mt-4">
                                <table class="table table-hover" id="tbl-received-order">
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
                <button class="btn btn-sm btn-outline-dark float-right" id="btn-print" type="button">Print</button><br>
                  <div class="row mt-4" id="user-info">
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