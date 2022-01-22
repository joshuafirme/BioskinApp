@extends('admin.archive.layout')

@section('content')

@php
    $page_title = "Bioskin | Archive";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Archive</h3>
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
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Sub category</th>
                            <th>Qty</th>
                            <th>Variation</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Volumes</th>
                            <th>Date time archived</th>
                            <th>Action</th>
                        </tr>
                        @if (count($product) > 0)
                        @foreach ($product as $data)
                        <tr id="record-id-{{ $data->id }}">
                            <td>{{ $data->sku }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ Utils::readCategoriesByIDs($data->category_id) }}</td>
                            <td>{{ Utils::readCategoriesByIDs($data->sub_category_id) }}</td>
                            <td>{{ $data->qty }}</td>
                            <td>{{ $data->variation }}</td>
                            <td>{{ $data->size }}</td>
                            <td>{{ $data->price }}</td>
                            <td>{{ Utils::readVolumes($data->sku) }}</td>
                            <td>{{ $data->updated_at }}</td>
                            <td>                     
                                <button data-toggle="modal" data-target="#confirmation-modal" class="btn btn-archive" data-id="{{$data->id}}"><i class="fas fa-recycle"></i></button>
                            </td>    
                        </tr>
                        @endforeach
                        @else 
                            <td colspan="11"><div class="alert alert-light text-center">No archive yet</div></td>
                        @endif
                    </table>
                    {!! $product->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
