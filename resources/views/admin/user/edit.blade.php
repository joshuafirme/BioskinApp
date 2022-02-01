@extends('admin.user.layout')

@section('content')

@php
    $page_title = "Update User | Bioskin";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Update User</h3>
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
                    <form action="{{ route('users.update',$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label class="col-form-label">Last name</label>
                                <input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label class="col-form-label">First name</label>
                                <input type="text" class="form-control" name="firstname"  value="{{ $user->firstname }}" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label class="col-form-label">Middle</label>
                                <input type="text" class="form-control" name="middlename" value="{{ $user->middlename }}">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                            </div>
                              <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" required>
                              </div>
                              <div class="col-sm-12 col-md-6 mt-2">
                                  <label class="col-form-label">Phone number</label>
                                  <input type="tel" class="form-control" name="phone_no" value="{{ $user->phone_no }}" required>
                              </div>
                
                              <div class="col-sm-12 col-md-6 mt-2">    
                                <label class="col-form-label">Department</label>
                                @php
                                   // $disabled = $user->access_rights == 1 ? "disabled" : "";
                                @endphp
                                <select class="form-control" name="access_rights" id="access_rights">
                                    <option value="1"{{ $user->access_rights == 1 ? 'selected' : '' }}>Sales Admin</option>
                                    <option value="2"{{ $user->access_rights == 2 ? 'selected' : '' }}>Customer</option>
                                    <option value="3"{{ $user->access_rights == 3 ? 'selected' : '' }}>Sales Department</option>
                                    <option value="4"{{ $user->access_rights == 4 ? 'selected' : '' }}>Accounting</option>
                                    <option value="5"{{ $user->access_rights == 5 ? 'selected' : '' }}>Production</option>
                                    <option value="6"{{ $user->access_rights == 6 ? 'selected' : '' }}>Finish Goods</option>
                                    <option value="7"{{ $user->access_rights == 7 ? 'selected' : '' }}>Logistics/Warehousing</option>
                                    <option value="8"{{ $user->access_rights == 8 ? 'selected' : '' }}>Customer Service Representative</option>
                                </select>
                              </div>

                              <div class="col-sm-12 col-md-6 mt-2 d-none courier-container">    
                                <label class="col-form-label">Courier</label>
                                <select class="form-control" name="courier_id" id="courier_id">
                                    <option value="0">-- Select courier --</option>
                                    @foreach ($courier as $item)
                                    @php
                                        $selected = $user->courier_id == $item->id ? "selected" : "";
                                    @endphp
                                    <option {{$selected}} value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                              </div>

                              
                              @php
                                  $pages_array = Utils::getPages();
                                  $allowed_pages_array = $user->allowed_pages != null ? explode(",",$user->allowed_pages) : [];
                              @endphp
                              <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label" for="choices-multiple-remove-button">Allowed Pages</label>
                                <select class="form-control" name="allowed_pages[]" id="choices-multiple-remove-button" placeholder="Select tab"
                                multiple>
                                @foreach ($pages_array as $item)
                                    @php
                                        $selected = $pages_array && in_array($item, $allowed_pages_array) ? "selected" : "";
                                    @endphp
                                  <option {{$selected}} value="{{$item}}">{{ $item }}</option>
                                @endforeach
                              </select>
                              </div>

                              @php
                                  $modules_array = Utils::getModules();
                                  $allowed_modules_array = $user->allowed_modules != null ? explode(",",$user->allowed_modules) : [];
                              @endphp
                              <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label" for="choices-multiple-remove-button">Allowed Manage Order Tab</label>
                                <select class="form-control" name="allowed_modules[]" id="choices-multiple-remove-button" placeholder="Select tab"
                                multiple>
                                @foreach ($modules_array as $item)
                                    @php
                                        $selected = $modules_array && in_array($item, $allowed_modules_array) ? "selected" : "";
                                    @endphp
                                  <option {{$selected}} value="{{$item}}">{{ $item }}</option>
                                @endforeach
                              </select>
                              </div>
                              
                            <div class="col-sm-6 mt-2">
                                <label class="col-form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option {{ $user->status == 1 ? "selected" : "" }} value="1">Active</option>
                                    <option {{ $user->status == 0 ? "selected" : "" }} value="0">Blocked</option>
                                </select>
                            </div>


                              <div class="col-sm-12 col-md-6 mt-2 new-password-container d-none">
                                <label class="col-form-label">New password</label>
                                <input type="password" class="form-control" name="password" id="password" autocomplete="new-password">
                              </div>

                              <div class="col-sm-12 mt-2 new-password-container d-none">
                                <a class="btn btn-sm btn-default" id="cancel">Cancel</a>
                              </div>
                              
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-success mr-2" id="btn-add-user">Save changes</button>
                                <a class="btn btn-sm btn-primary" id="btn-change-password">Change password</a>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection