@extends('admin.manage-site.layout')

@section('content')


@php
    $page_title = "Bioskin | Manage Site | Footer";

@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Manage Site | Footer</h3>
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
                        <form action="{{ action('ManageSiteController@updateFooter') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                <h3>Social Links</h3>
                                <span><small>You can you can leave it blank if you don't want display them.</small></span>
                                </div>
                                <div class="input-group col-12 mt-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white px-4 border-md border-right-0">
                                            <i class="fab fa-facebook-f text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="facebook" value="{{ isset($data['facebook']) ? $data['facebook'] : "" }}"
                                        class="form-control bg-white border-left-0 border-md">
                                </div>
    
                                <div class="input-group col-12 mt-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white px-4 border-md border-right-0">
                                            <i class="fab fa-instagram text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="instagram" value="{{ isset($data['instagram']) ? $data['instagram'] : "" }}"
                                        class="form-control bg-white border-left-0 border-md">
                                </div>

                                <div class="input-group col-12 mt-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white px-4 border-md border-right-0">
                                            <i class="fab fa-tiktok text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="tiktok" value="{{ isset($data['tiktok']) ? $data['tiktok'] : "" }}"
                                        class="form-control bg-white border-left-0 border-md">
                                </div>

                                <div class="input-group col-12 mt-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white px-4 border-md border-right-0">
                                            <i class="fas fa-store text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="store" value="{{ isset($data['store']) ? $data['store'] : "" }}"
                                        class="form-control bg-white border-left-0 border-md">
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <label class="col-form-label">Copyright</label>
                                    <textarea rows="3" type="text" class="form-control" required name="copyright">{{ isset($data['copyright']) ? $data['copyright'] : "" }}</textarea>
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
