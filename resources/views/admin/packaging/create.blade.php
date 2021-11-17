@extends('admin.packaging.layout')

@section('content')

@php
    $page_title = "Bioskin | Create Packaging/Closures";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Create Packaging/Closures</h3>
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
                    <form action="{{ route('packaging.store') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">SKU</label>
                                <input type="text" class="form-control" name="sku" required>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name"  id="name" required>
                            </div>

                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Category</label>
                                  <select class="form-control" name="category_id">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                  </select>
                              </div>

                              <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Sub Category</label>
                                  <select class="form-control" name="sub_category_id">
                                  </select>
                              </div>
    
                              <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label" for="choices-multiple-remove-button">Volumes</label>
                                <input class="form-control" name="volumes" id="choices-text-remove-button" type="text" value="" placeholder="Enter volume">
                              </div>

                              <div class="col-sm-12 col-md-6 mt-sm-2 mt-md-3">
                                <label for="choices-single-default">Size</label>
                                <input type="text" class="form-control" name="size" required>
                            </div>
    
                              <div class="col-sm-12 col-md-6 mt-sm-2">
                                <label class="col-form-label">Price</label>
                                <input type="number" step="any" class="form-control" name="price" required>
                              </div>
    
                              <div class="col-sm-12 col-md-12 mt-2">
                                <label class="col-form-label" for="choices-multiple-remove-button">Choose multiple images</label>
                                <input type="file" class="form-control-file" name="images[]" placeholder="address" multiple accept=".jpg,.jpeg,.png">
                              </div>
    
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save</button>
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