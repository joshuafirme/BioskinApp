@extends('admin.courier.layout')

@section('content')

@php
    $page_title = "Bioskin | Courier Maintenance";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Courier Maintenance</h3>
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

        

        <a href="{{ route('courier.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Create courier</a>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-courier" id="courier-table">
                        <tr>
                            <th class="py-2 text-left">Courier Name</th>
                            <th class="py-2 text-left">Receive by</th>
                            <th class="py-2 text-left">Status</th>
                            <th class="py-2 text-left">Action</th>
                        </tr>
                        @foreach ($courier as $data)
                        <tr id="record-id-{{ $data->id }}">
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->receive_by }}</td>
                            @if ($data->status == 1)
                                <td><span class="badge badge-success">Active</span></td>
                            @else 
                                <td><span class="badge badge-secondary">Inactive</span></td>
                            @endif
                            <td>
                                <form action="{{ route('courier.destroy',$data->id) }}" method="POST">                      
                                    <a class="btn" href="{{ route('courier.edit',$data->id) }}"><i class="fas fa-edit"></i></a>
            
                                    @csrf
                                    @method('DELETE')
            
                                    <a record-id="{{ $data->id }}" object="courier"
                                        class="btn delete-record"><i class="fas fa-trash"></i></a>
                                </form>  
                            </td>    
                        </tr>
                        @endforeach
                    </table>
                    {!! $courier->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection