@extends('admin.voucher.layout')

@section('content')

@php
    $page_title = "Bioskin | Voucher Maintenance";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Voucher Maintenance</h3>
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

        

        <a href="{{ route('voucher.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Create voucher</a>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-voucher" id="voucher-table">
                        <tr>
                            <th class="py-2 text-left">Voucher Code</th>
                            <th class="py-2 text-left">Disount Amount</th>
                            <th class="py-2 text-left">Status</th>
                            <th class="py-2 text-left">Action</th>
                        </tr>
                        @if(count($voucher) > 0)
                        @foreach ($voucher as $data)
                        <tr id="record-id-{{ $data->id }}">
                            <td>{{ $data->voucher_code }}</td>
                            <td>{{ $data->discount }}</td>
                            @if ($data->status == 1)
                                <td><span class="badge badge-success">Active</span></td>
                            @else 
                                <td><span class="badge badge-secondary">Inactive</span></td>
                            @endif
                            <td>
                                <form action="{{ route('voucher.destroy',$data->id) }}" method="POST">                      
                                    <a class="btn" href="{{ route('voucher.edit',$data->id) }}"><i class="fas fa-edit"></i></a>
            
                                    @csrf
                                    @method('DELETE')
            
                                    <a record-id="{{ $data->id }}" object="voucher"
                                        class="btn delete-record"><i class="fas fa-trash"></i></a>
                                </form>  
                            </td>    
                        </tr>
                        @endforeach
                        @else 
                        <td colspan="4"><p class="text-center">No voucher found.</p></td>
                        @endif
                    </table>
                    {!! $voucher->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection