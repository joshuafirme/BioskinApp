@extends('admin.packaging.layout')

@section('content')

@php
    $page_title = "Bioskin | Packaging Maintenance";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Packaging Maintenance</h3>
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

        

        <a href="{{ route('packaging.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Create packaging</a>
        <a href="{{ route('delete-packaging-cache') }}" class="btn btn-secondary btn-sm"> Delete Cache</a>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-packaging" id="packaging-table">
                        <thead>
                            <tr>
                                 <th>SKU</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Sub category</th>
                                <th>Qty</th>
                                <th>Variation</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Volumes</th>
                                <th>Packaging</th>
                                <th>Closures</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection