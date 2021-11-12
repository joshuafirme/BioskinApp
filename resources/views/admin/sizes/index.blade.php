@extends('admin.sizes.layout')

@section('content')

@php
    $page_title = "Bioskin | Size Maintenance";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Size Maintenance</h3>
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

        

        <a href="{{ route('size.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Create size</a>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-size" id="size-table">
                        <tr>
                            <th class="py-2 text-left">Size Name</th>
                            <th class="py-2 text-left">Action</th>
                        </tr>
                        @foreach ($sizes as $data)
                        <tr id="record-id-{{ $data->id }}">
                            <td>{{ $data->name }}</td>
                            
                            <td>
                                <form action="{{ route('size.destroy',$data->id) }}" method="POST">                      
                                    <a class="btn" href="{{ route('size.edit',$data->id) }}"><i class="fas fa-edit"></i></a>
            
                                    @csrf
                                    @method('DELETE')
            
                                    <a record-id="{{ $data->id }}" object="size"
                                        class="btn delete-record"><i class="fas fa-trash"></i></a>
                                </form>  
                            </td>    
                        </tr>
                        @endforeach
                    </table>
                    {!! $sizes->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection