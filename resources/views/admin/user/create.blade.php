@extends('admin.user.layout')

@section('content')

@php
    $page_title = "Create User | Bioskin";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Create User</h3>
        <hr>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><span class='fas fa-arrow-left'></span></a>
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
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> </h5>
                {{ \Session::get('success') }}
            </div>
        </div>
        </div>

       
        @endif


        <div class="row">

          <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label class="col-form-label">Last name</label>
                                <input type="text" class="form-control" name="lastname" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label class="col-form-label">First name</label>
                                <input type="text" class="form-control" name="firstname" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label class="col-form-label">Middle</label>
                                <input type="text" class="form-control" name="middlename" >
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Phone number</label>
                                <input type="tel" class="form-control" name="phone_no" required>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                              <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                              </div>
                              <div class="col-sm-12 col-md-6 mt-2">
                                  <label class="col-form-label">Password</label>
                                  <input type="password" class="form-control" name="password" required>
                              </div>
                
                              <div class="col-sm-12 col-md-6 mt-2">    
                                <label class="col-form-label">Department</label>
                                <select class="form-control" name="access_rights" id="access_rights">
                                    <option value="1">Sales Admin</option>
                                    <option value="2">Customer</option>
                                    <option value="3">Sales Department</option>
                                    <option value="4">Accounting</option>
                                    <option value="5">Production</option>
                                    <option value="6">Finish Goods</option>
                                    <option value="7">Logistics/Warehousing</option>
                                    <option value="8">Customer Service Representative</option>
                                </select>
                              </div>

                              <div class="col-sm-12 col-md-6 mt-2 d-none courier-container">    
                                <label class="col-form-label">Courier</label>
                                <select class="form-control" name="courier_id" id="courier_id">
                                    <option value="0">-- Select courier --</option>
                                    @foreach ($courier as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                              </div>

                            @php
                              $pages_array = Utils::getPages();
                            @endphp
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label" for="choices-multiple-remove-button">Allowed Pages</label>
                                <select class="form-control" name="allowed_pages[]" id="choices-multiple-remove-button" placeholder="Select tab"
                                multiple>
                                @foreach ($pages_array as $item)
                                    <option value="{{$item}}">{{ $item }}</option>
                                @endforeach
                            </select>
                            </div>

                            @php
                                $modules_array = Utils::getModules();
                            @endphp
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label" for="choices-multiple-remove-button">Allowed Manage Order Tab</label>
                                <select class="form-control" name="allowed_modules[]" id="choices-multiple-remove-button" placeholder="Select tab"
                                multiple>
                                @foreach ($modules_array as $item)
                                    <option value="{{$item}}">{{ $item }}</option>
                                @endforeach
                            </select>
                            </div>
                              
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-success mr-2" id="btn-add-user">Add user</button>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection