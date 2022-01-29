@extends('admin.category.layout')

@section('content')

@php
    $page_title = "Bioskin | Create Category";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Update Category</h3>
        <hr>
        <a href="{{ route('category.index') }}" class="btn btn-secondary btn-sm"><span class='fas fa-arrow-left'></span></a>
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

          <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('category.update',$category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Category Name</label>
                                <input type="text" class="form-control" name="name"  id="name" value="{{ $category->name }}"  required>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Image</label>
                                <input type="file" class="form-control-file" name="image" accept=".jpg,.jpeg,.png">
                            </div>

                            <div class="col-sm-12 mt-2">
                                <label class="col-form-label">Wording</label>
                                <textarea rows="3" type="text" class="form-control" name="wording">{{ $category->wording }}</textarea>
                            </div>

                            <div class="col-sm-12 mt-4">
                                <img src="{{ asset('images/'.$category->image) }}" style="height: 300px;background-size:cover; background-position:center;'"  alt="product image">
                            </div>

                            <div class="col-sm-6 mt-2">
                                <label class="col-form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option {{ $category->status == 1 ? "selected" : "" }} value="1">Active</option>
                                    <option {{ $category->status == 0 ? "selected" : "" }} value="0">Inactive</option>
                                </select>
                            </div>

                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save changes</button>
                                <a href="{{ route('category.index') }}" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</a>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection