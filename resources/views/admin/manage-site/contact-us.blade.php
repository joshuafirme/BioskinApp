@extends('admin.manage-site.layout')

@section('content')


@php
    $page_title = "Bioskin | Manage Site | Contact Us";

@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Manage Site | Contact Us</h3>
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
        

        <div class="row">
            <div class="col-md-12 col-lg-12 mt-3">
                @include('includes.alerts')
                <div class="card">
                    <div class="card-body">
                        <form action="{{ action('ManageSiteController@updateContactUs') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="col-form-label">Location</label>
                                    <textarea rows="3" type="text" class="form-control" name="location" required>{{ isset($data['location']) ? $data['location'] : "" }}</textarea>
                                </div>
    
                                <div class="col-sm-12 mt-2">
                                    <label class="col-form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number" value="{{isset( $data['phone_number']) ?  $data['phone_number'] : "" }}" required>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <label class="col-form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ isset($data['email']) ? $data['email'] : "" }}" required>
                                </div>
    
                                <div class="col-sm-12">
                                    <label class="col-form-label">Image</label>
                                    <input type="file" class="form-control-file" name="image" accept=".jpg,.jpeg,.png">
                                </div>

                                <div class="col-sm-12 col-md-6 mt-2">
                                    <img width="100%" class="img-thumbnail" src="{{ asset('images/'.isset($data['image']) && $data['image'] ? $data['image'] : "") }}" alt="">
                                </div>

        
                                  <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save</button>
                                  </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
@endsection
