@extends('admin.packaging.layout')

@section('content')

@php
    $page_title = "Bioskin | Create packaging";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Update Packaging</h3>
        <hr>
        <a href="{{ route('packaging.index') }}" class="btn btn-secondary btn-sm"><span class='fas fa-arrow-left'></span></a>
    </div>

        @if(count($errors)>0)
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
            
                        <li>{{$error}}</li>
                            
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    
        @if(\Session::has('success'))
        <div class="col-sm-12 col-md-8">
            <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> </h5>
            {{ \Session::get('success') }}
            </div>
        </div>
       
        @endif


        <div class="row">

          <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('packaging.update',$packaging->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">SKU</label>
                                <input type="text" class="form-control" name="sku" value="{{ $packaging->sku }}" required>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $packaging->name }}"  id="name" required>
                            </div>

                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Category</label>
                                  <select class="form-control" name="category_id">
                                    @foreach ($categories as $item)
                                    @php
                                        $selected = $item->id == $packaging->category_id ? 'selected' : "";
                                    @endphp
                                    <option {{ $selected }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                  </select>
                              </div>

                              <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Sub Category</label>
                                  <select class="form-control" name="sub_category_id">
                                    @foreach ($subcategories as $item)
                                    @php
                                    if($item->id == $packaging->sub_category_id) {
                                        $selected = $item->id == $packaging->sub_category_id ? 'selected' : "";
                                    }else {
                                      continue;
                                    }
                                    @endphp
                                    <option {{ $selected }} value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endforeach
                                  </select>
                              </div>
    
                              <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label" for="choices-multiple-remove-button">Volumes</label>
                                <input class="form-control" name="volumes" id="choices-text-remove-button" type="text" value="{{ $packaging->volumes }}" placeholder="Enter volume">
                              </div>

                              <div class="col-sm-12 col-md-6 mt-sm-2 mt-md-3">
                                <label for="choices-single-default">Size</label>
                                <input type="text" class="form-control" name="size" value="{{ $packaging->size }}" required>
                            </div>
    
                              <div class="col-sm-12 col-md-6 mt-sm-2">
                                <label class="col-form-label">Price</label>
                                <input type="number" step="any" class="form-control" name="price" value="{{ $packaging->price }}" required>
                              </div>
    
                              <div class="col-sm-12 col-md-12 mt-2">
                                <label class="col-form-label" for="choices-multiple-remove-button">Add multiple images</label>
                                <input type="file" class="form-control-file" name="images[]" placeholder="address" multiple accept=".jpg,.jpeg,.png">
                              </div>
                              @foreach ($images as $item)
                              <div class="row mt-2">
                                <div class="col-sm-12 col-md-3 col-lg-6 m-1 image-container">
                                  <div class="card" style="width: 18rem;">
                                    <input type="hidden" name="image_id" value="{{ $item->id }}">
                                    <img src="{{ asset('images/'.$item->image) }}" class="card-img-top" style="height: 300px;background-size:cover; background-position:center;'"  alt="product image">
                                    <a class="btn btn-sm btn-danger btn-delete-image" data-id="{{$item->id}}">Delete Photo</a>
                                  </div>
                                  
                                </div>
                              </div>
                            
                          @endforeach
    
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save changes</button>
                                <a href="{{ route('packaging.index') }}" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</a>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection