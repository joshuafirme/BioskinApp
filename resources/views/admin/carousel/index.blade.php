@extends('admin.carousel.layout')

@section('content')

@php
    $page_title = "Bioskin | Carousel Maintenance";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Carousel Maintenance</h3>
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

        

        <a href="{{ route('carousel.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Add image</a>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-carousel" id="carousel-table">
                        <tr>
                            <th class="py-2 text-left">Image</th>
                            <th class="py-2 text-left">Order</th>
                            <th class="py-2 text-left">Action</th>
                        </tr>
                        @foreach ($carousel as $data)
                        <tr id="record-id-{{ $data->id }}">
                            <td><img src="{{ asset('images/'.$data->image) }}" class="img-fluid" width="250" alt=""></td>
                            <td>{{ $data->order }}</td>
                            <td>
                                <form action="{{ route('carousel.destroy',$data->id) }}" method="POST">                      
                                    <a class="btn" href="{{ route('carousel.edit',$data->id) }}"><i class="fas fa-edit"></i></a>
            
                                    @csrf
                                    @method('DELETE')
            
                                    <a record-id="{{ $data->id }}" object="carousel"
                                        class="btn delete-record"><i class="fas fa-trash"></i></a>
                                </form>  
                            </td>    
                        </tr>
                        @endforeach
                    </table>
                    {!! $carousel->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection