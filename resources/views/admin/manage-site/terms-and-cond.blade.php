@extends('admin.manage-site.layout')

@section('content')


@php
    $page_title = "Bioskin | Manage Site | Terms and Conditions";

@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Manage Site | Terms and Conditions</h3>
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
                        <form action="{{ action('ManageSiteController@updateTermsAndCond') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea rows="10" type="text" class="form-control" id="summernote" name="terms_and_cond" required>{{ Cache::get('cache_terms_and_cond') }}</textarea>
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

