@extends('admin.manage-site.layout')

@section('content')


@php
    $page_title = "Bioskin | Manage Site | About Us";

@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Manage Site | About Us</h3>
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
                        <form action="{{ action('ManageSiteController@updateAboutUs') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="col-form-label">About Us Text</label>
                                    <textarea rows="10" type="text" class="form-control" name="about_text" required>{{ $data['about_text'] }}</textarea>
                                </div>
    
                                <div class="col-sm-12 mt-3">
                                    <label class="col-form-label">Image</label>
                                    <input type="file" class="form-control-file" name="image" accept=".jpg,.jpeg,.png">
                                </div>

                                <div class="col-sm-12 col-md-6 mt-2">
                                    <img width="100%" class="img-thumbnail" src="{{ asset('images/'.$data['image']) }}" alt="">
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <div class="form-check">
                                        @php
                                            $checked = isset($data['display_image']) && $data['display_image'] == 1 ? "checked" : "";
                                        @endphp
                                        <input type="checkbox" {{$checked}} class="form-check-input" name="display_image" id="rebranding" value="1">
                                        <label class="form-check-label" for="exampleCheck1">Display Image</label>
                                      </div>
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
