@extends('admin.products.layout')

@section('content')

@php
    $page_title = "Bioskin | Product Maintenance";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Product Maintenance</h3>
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
    
        @if(\Session::has('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> </h5>
          {{ \Session::get('success') }}
        </div>

       
        @endif

        

        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Create product</a>
        <a href="{{ route('delete-product-cache') }}" class="btn btn-secondary btn-sm"> Delete Cache</a>
        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover tbl-product">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Sub category</th>
                                <th>Variation</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Volumes</th>
                                <th>Packaging</th>
                                <th>Closures</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p class="delete-message"></p>
            </div>
            <div class="modal-footer">
              <button class="btn btn-sm btn-outline-dark btn-confirm-archive" type="button">Yes</button>
              <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
@endsection