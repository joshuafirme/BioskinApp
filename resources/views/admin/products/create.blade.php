@extends('admin.products.layout')

@section('content')

@php
    $page_title = "Bioskin | Create product";
@endphp

<div class="content-header"></div>


    <div class="page-header mb-3 mt-2">
      <h3 class="mt-2" id="page-title">Create Product</h3>
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
                  <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                      @csrf
                      <div class="row">

                        <div class="col-sm-12 col-md-6 mt-2 packaging">
                          <label class="col-form-label" for="choices-multiple-remove-button">Category</label>
                          <select class="form-control" name="category_id[]" id="choices-multiple-remove-button" placeholder="Select category" required
                          multiple>
                          @foreach ($categories as $item)
                          @php
                              if($item->name == 'Packaging')
                              continue;
                          @endphp
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                        </select>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2 packaging">
                          <label class="col-form-label" for="choices-multiple-remove-button">Subcategory</label>
                          <select class="form-control" name="sub_category_id[]" id="choices-multiple-remove-button" placeholder="Select subcategory" required
                          multiple>
                          @foreach ($subcategories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                        </select>
                        </div>
                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">SKU</label>
                            <input type="text" class="form-control" name="sku" required>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Product name</label>
                            <input type="text" class="form-control" name="name" required>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Description</label>
                            <textarea type="text" class="form-control" name="description" rows="4"></textarea>
                          </div>
                          
                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Directions</label>
                            <textarea type="text" class="form-control" name="directions" rows="4"></textarea>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Precautions</label>
                            <textarea type="text" class="form-control" name="precautions" rows="4"></textarea>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Ingredients</label>
                            <textarea type="text" class="form-control" name="ingredients" rows="4"></textarea>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2">
                            <label class="col-form-label">Variation Code</label>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <a class="btn btn-outline-secondary" id="btn-generate-varation-code">Generate</a>
                              </div>
                              <input type="text" name="variation_code" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            </div>
                          </div>
                          

                          <div class="col-sm-12 col-md-6 mt-sm-2 mt-md-3">
                              <label for="choices-single-default">Variation</label>
                              <select class="form-control" data-trigger  name="variation_id">
                                <option value="0">Select variation</option>
                                @foreach ($variations as $item)
                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                              </select>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-sm-2">
                            <label class="col-form-label">Quantity</label>
                            <input type="number" step="any" class="form-control" name="qty" required>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-sm-2 mt-md-3">
                              <label for="choices-single-default">Size</label>
                              <input type="text" class="form-control" name="size" required>
                          </div>
                          
                          <div class="col-sm-12 col-md-6 mt-sm-2">
                            <label class="col-form-label">Retail Price</label>
                            <input type="number" step="any" class="form-control" name="price" required>
                          </div>

                          <div class="col-sm-12 mt-2">
                            <label class="col-form-label" for="choices-multiple-remove-button">Volumes</label>
                            <input class="form-control" name="volumes" id="choices-text-remove-button" type="text" value="" placeholder="Enter volume">
                          </div>

                          <div class="col-md-12">
                            <div class="row price-container"> 
                            </div>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2 packaging">
                            <label class="col-form-label" for="choices-multiple-remove-button">Packaging</label>
                           <!-- <small class="text-secondary" style="top:-10px"> - First selected option is the default closure for retail.</small>-->
                            <select class="form-control mb-0" name="packaging[]" id="choices-multiple-remove-button" placeholder="Select packaging"
                            multiple>
                            @foreach ($packaging as $item)
                              <option value="{{$item->id}}">{{$item->name}} {{ $item->size }}</option>
                            @endforeach
                          </select>
                          </div>

                          <div class="col-sm-12 col-md-6 mt-2 packaging">
                            <label class="col-form-label" for="choices-multiple-remove-button">Closures</label>
                           <!-- <small class="text-secondary" style="top:-10px"> - First selected option is the default closure for retail.</small>-->
                            <select class="form-control" name="closures[]" id="choices-multiple-remove-button" placeholder="Select closures"
                            multiple>
                            @foreach ($packaging as $item)
                            <option value="{{$item->id}}">{{$item->name}} {{ $item->size }}</option>
                            @endforeach
                          </select>
                          </div>
                          

                          <div class="col-sm-12 mt-3">
                              
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="rebranding" id="rebranding" value="1">
                            <label class="form-check-label" for="exampleCheck1">Rebranding</label>
                          </div>
                          </div>

                          <div class="col-sm-12 col-md-12 mt-2">
                            <label class="col-form-label" for="choices-multiple-remove-button">Choose multiple images</label>
                            <input type="file" class="form-control-file" name="images[]" id="images" placeholder="address" multiple accept=".jpg,.jpeg,.png">
                          </div>
                          


  
                            <div class="col-12 mt-4">
                              <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save</button>
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