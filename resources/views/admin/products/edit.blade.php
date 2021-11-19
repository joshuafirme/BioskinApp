@extends('admin.products.layout')

@section('content')

<style>
  .choices__button {
    background-image: url('https://img.icons8.com/ios/50/000000/delete-sign--v1.png') !important;
   
  }
</style>
@php
    $page_title = "Bioskin | Update product";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Update Product</h3>
        <hr>
        <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm"><span class='fas fa-arrow-left'></span></a>
    </div>

        @if(count($errors)>0)
        <div class="row">
            <div class="col-sm-12 col-md-12">
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
        <div class="col-sm-12 col-md-12">
            <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> </h5>
            {{ \Session::get('success') }}
          </div>
        </div>
       
        @endif


        <div class="row">

          <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                               <div class="col-sm-12 col-md-6 mt-2">
                          <label class="col-form-label">Category</label>
                            <select class="form-control" name="category_id">
                              @foreach ($categories as $item)
                                  @php
                                      $selected = $item->id == $product->category_id ? 'selected' : "";
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
                                if($item->id == $product->sub_category_id) {
                                    $selected = $item->id == $product->sub_category_id ? 'selected' : "";
                                }else {
                                  continue;
                                }
                                @endphp
                                <option {{ $selected }} value="{{ $item->id }}">{{ $item->name }}</option>
                              @endforeach
                            </select>
                        </div>
                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">SKU</label>
                            <input type="text" class="form-control" name="sku" value="{{ $product->sku }}" required>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Product name</label>
                            <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Features</label>
                            <textarea type="text" class="form-control" name="features" rows="4">{{ $product->features }}</textarea>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Description</label>
                            <textarea type="text" class="form-control" name="description" rows="4">{{ $product->description }}</textarea>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Ingredients</label>
                            <textarea type="text" class="form-control" name="ingredients" rows="4">{{ $product->ingredients }}</textarea>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Drections and Precautions</label>
                            <textarea type="text" class="form-control" name="directions_and_precautions" rows="4">{{ $product->directions_and_precautions  }}</textarea>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Variation Code</label>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <a class="btn btn-outline-secondary" id="btn-generate-varation-code" type="button">Generate</a>
                              </div>
                              <input type="text" name="variation_code" value="{{ $product->variation_code  }}" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            </div>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-sm-2 mt-md-3">
                              <label for="choices-single-default">Variation</label>
                              <select class="form-control" data-trigger  name="variation_id">
                                <option value="0">Select variation</option>
                                @foreach ($variations as $item)
                                  @php
                                      $selected = $item->id == $product->variation_id ? 'selected' : "";
                                  @endphp
                                  <option {{ $selected }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                              </select>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-sm-2 mt-md-3">
                              <label for="choices-single-default">Size</label>
                              <input type="text" class="form-control" name="size" value="{{ $product->size }}" required>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-sm-2">
                            <label class="col-form-label">Retail Price</label>
                            <input type="number" step="any" class="form-control" name="price" value="{{ $product->price }}" required>
                          </div>

                          <div class="col-sm-12 mt-2">
                            <label class="col-form-label" for="choices-multiple-remove-button">Volumes</label>
                            <input class="form-control" name="volumes" id="choices-text-remove-button" type="text" value="{{ $volumes }}" placeholder="Enter volume">
                          </div>

                          <div class="col-md-12">
                            <div class="row price-container"> 
                            </div>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2 packaging">
                            <label class="col-form-label" for="choices-multiple-remove-button">Packaging</label>
                            <select class="form-control" name="packaging[]" id="choices-multiple-remove-button" placeholder="Select packaging"
                            multiple>
                            @foreach ($packaging as $item)
                                @php
                                    $selected = $selected_packaging_arr && in_array($item->id, $selected_packaging_arr) ? "selected" : "";
                                @endphp
                              <option {{$selected}} value="{{$item->id}}">{{$item->name}} {{ $item->size }}</option>
                            @endforeach
                          </select>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2 packaging">
                            <label class="col-form-label" for="choices-multiple-remove-button">Closures</label>
                            <select class="form-control" name="closures[]" id="choices-multiple-remove-button" placeholder="Select packaging"
                            multiple>
                            @foreach ($packaging as $item)
                                @php
                                    $selected = $selected_closures_arr && in_array($item->id, $selected_closures_arr) ? "selected" : "";
                                @endphp
                              <option {{$selected}} value="{{$item->id}}">{{$item->name}} {{ $item->size }}</option>
                            @endforeach
                          </select>
                          </div>

                          <div class="col-sm-12 mt-3">
                              
                          <div class="form-check">
                            @php
                                $checked = $product->rebranding == 1 ? "checked" : "";
                            @endphp
                            <input type="checkbox" class="form-check-input" name="rebranding" id="rebranding" {{ $checked }} value="{{ $product->rebranding }}">
                            <label class="form-check-label" for="exampleCheck1">Rebranding</label>
                          </div>
                          </div>

                          <div class="col-sm-12 col-md-12 mt-2">
                            <label class="col-form-label" for="choices-multiple-remove-button">Upload images</label>
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
                                <a href="{{ route('product.index') }}" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</a>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection