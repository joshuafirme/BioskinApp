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

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="packaging-table">
                        <tr>
                            <th class="py-2 text-left">SKU</th>
                            <th class="py-2 text-left">Packaging Name</th>
                            <th class="py-2 text-left">Category</th>
                            <th class="py-2 text-left">Subcategory</th>
                            <th class="py-2 text-left">Volumes</th>
                            <th class="py-2 text-left">Size</th>
                            <th class="py-2 text-left">Price</th>
                            <th class="py-2 text-left">Action</th>
                        </tr>
                        @foreach ($packaging as $data)
                        <tr id="record-id-{{ $data->id }}">
                            <td>{{ $data->sku }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->category }}</td>
                            <td>{{ $data->subcategory }}</td>
                            <td>
                            @php
                              $volumes = explode(",",$data->volumes);
                            @endphp
                            @foreach ($volumes as $volume) 
                                <span class="badge badge-primary m-1">{{$volume}}</span>
                            @endforeach
                            </td>
                            <td>{{ $data->size }}</td>
                            <td>{{ $data->price }}</td>
                            <td>
                                <form action="{{ route('packaging.destroy',$data->id) }}" method="POST">                      
                                    <a class="btn" href="{{ route('packaging.edit',$data->id) }}"><i class="fas fa-edit"></i></a>
            
                                    @csrf
                                    @method('DELETE')
            
                                    <a record-id="{{ $data->id }}" object="packaging"
                                        class="btn delete-record"><i class="fas fa-trash"></i></a>
                                </form>  
                            </td>    
                        </tr>
                        @endforeach
                    </table>
                    {!! $packaging->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection