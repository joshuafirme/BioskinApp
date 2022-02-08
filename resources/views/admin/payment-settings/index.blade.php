@extends('admin.payment-settings.layout')

@section('content')

@php
    $page_title = "Bioskin | Payment Settings";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Payment Settings</h3>
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

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <th>Mode of Payment</th>
                            <th>Enable on Retail</th>
                            <th>Enable on Rebrand</th>
                        </tr>
                        @foreach ($payment_settings as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            @php
                                $enable_on_retail_check = $item->enable_on_retail == 1 ? "checked" : "";
                                $enable_on_rebrand_check = $item->enable_on_rebrand == 1 ? "checked" : "";
                            @endphp
                            <td><input type="checkbox" {{$enable_on_retail_check}} class="enable_on_retail" data-id="{{ $item->id }}"></td>
                            <td><input type="checkbox" {{$enable_on_rebrand_check}} class="enable_on_rebrand" data-id="{{ $item->id }}"></td>
                        </tr>      
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection