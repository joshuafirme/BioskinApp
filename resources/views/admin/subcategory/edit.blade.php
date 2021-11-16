@extends('admin.category.layout')

@section('content')

@php
    $page_title = "VCS | Create Category";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Update Category</h3>
        <hr>
        <a href="{{ route('subcategory.index') }}" class="btn btn-secondary btn-sm"><span class='fas fa-arrow-left'></span></a>
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
                    <form action="{{ route('subcategory.update',$subcategory->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            

                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Category</label>
                                <select class="form-control" name="category_id">
                                    @foreach ($category as $item)
                                        @php
                                            $selected = $item->id == $subcategory->category_id ? 'selected' : "";
                                        @endphp
                                        <option {{ $selected }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Subcategory Name</label>
                                <input type="text" class="form-control" name="name"  id="name" value="{{ $subcategory->name }}"  required>
                            </div>

                        <!--    <div class="col-sm-12 col-md-6 mt-2">    
                              <label class="col-form-label">Status</label>
                              <select class="form-control" name="status" id="status">
                                  <option selected value="1" // $category->status == 1 ? 'selected' : '' }}>Active</option>
                                  <option value="0" // $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                              </select>
                            </div>-->
    
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