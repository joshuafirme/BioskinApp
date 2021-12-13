@php
  $page_title = "Account | Bioskin";

 
    if (\Cache::get('categories-cache')) {
        $cache_categories = \Cache::get('categories-cache');
    }
    else {
        $cache_categories = \App\Models\Category::where('status', 1)->get();
    }          
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <style>
      .my-profile-container {
          background-color: #F4F4F4;
      }
      .inputfile {
  /* visibility: hidden etc. wont work */
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
.inputfile:focus + label {
  /* keyboard navigation */
  outline: 1px dotted #000;
  outline: -webkit-focus-ring-color auto 5px;
}
.inputfile + label * {
  pointer-events: none;
}
.custom-file-input::-webkit-file-upload-button {
  visibility: hidden;
}
.custom-file-input::before {
  content: 'Select some files';
  color: black;
  display: inline-block;
  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
  border: 1px solid #999;
  border-radius: 3px;
  padding: 5px 8px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  text-shadow: 1px 1px #fff;
  font-weight: 700;
  font-size: 10pt;
}
.custom-file-input:hover::before {
  border-color: black;
}
.custom-file-input:active {
  outline: 0;
}
.custom-file-input:active::before {
  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9); 
}
  
  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div ></div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="row pl-3 pr-3 pt-1 pb-1 justify-content-center" style="margin-top: 11px; background-color: #EFF6EC;">

        @foreach ($cache_categories as $item)
        <a class="col-6 col-sm-4 col-md-1 text-center" href="{{ url('/shop/category/'.$item->id) }}">
          <div class="text-muted category-name"  data-id="{{ $item->id }}" 
            data-name="{{ $item->name }}" >
            {{ $item->name }}</div> 
        </a>
      @endforeach
    </div> 
    <div class="breadcrumb-container ml-2 mt-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Account</li>
          </ol>
        </nav>
    </div>

    <div class="container">
        <div class="row" style="margin-bottom: 150px;">
            <div class="col-sm-3">
                @if ($user->image) 
                    <img class="img-thumbnail rounded-circle" width="75px" src="{{ asset('/images/'.$user->image) }}"/>
                @else 
                    <img src="https://img.icons8.com/small/75/000000/user-male-circle.png"/>
                @endif
                <span class="ml-2">{{ $user->firstname ." ". $user->middlename ." ". $user->lastname }}</span>
                <hr>
                <div class="text-center">
                <form action="{{ action('AccountController@update') }}" method="POST" enctype="multipart/form-data">
                    <input type="file" name="image" id="file" class="inputfile">
                    <label for="file" class="btn btn-light">Select image</label>
                </div>
                <div class="text-center">File Extension JPEG, PNG</div>
                <hr>
                <div class="ml-2">My Account</div>
                <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <li class="nav-item">
                      <a class="nav-link active" id="profile-tab"  data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="addresses-tab" data-toggle="tab" href="#addresses" role="tab" aria-controls="addresses">Addresses</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="change-password-tab" data-toggle="tab" href="#change-password" role="tab" aria-controls="change-password">Change password</a>
                    </li>
                  </ul>
            </div>
            <div class="col-sm-9">
                <div class="card my-profile-container">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <span class="card-title text-bold"><h4>My profile</h4></span>
                                <p class="card-text">Manage and Protect Your Account</p>
                                @include('includes.alerts')
                                    @csrf
                                    <div class="form-group row">
                                      <label for="staticEmail" class="col-sm-2 col-form-label">Full name</label>
                                      <div class="row col-sm-10">
                                        <div class="col-4">
                                            <input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}" placeholder="Last name" required>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}" placeholder="First name" required>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" name="middlename" value="{{ $user->middlename }}" placeholder="Middle name" required>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="input" class="col-sm-2 col-form-label">Username</label>
                                      <div class="col-sm-10">
                                        <input type="" class="form-control" value="{{ $user->username }}"  placeholder="username" required>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input" class="col-sm-2 col-form-label">Email address</label>
                                        <div class="col-sm-10">
                                          <input type="" class="form-control" value="{{ $user->email }}" name="email" placeholder="Email">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="input" class="col-sm-2 col-form-label">Phone number</label>
                                        <div class="col-sm-10">
                                          <input type="" class="form-control" value="{{ $user->phone_no }}" name="phone_no" placeholder="Phone number">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="input" class="col-sm-2 col-form-label">Gender</label>
                                        <div class="col-sm-10">
                                          <select type="" class="form-control" name="gender">
                                              <option value="" selected disabled>--select gender--</option>
                                              <option value="Male" {{ $user->gender == "Male" ? "selected" : "" }}>Male</option>
                                              <option value="Female" {{ $user->gender == "Female" ? "selected" : "" }}>Female</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="input" class="col-sm-2 col-form-label">Date of birth</label>
                                        <div class="col-sm-10">
                                          <input type="date" class="form-control" name="birth_date" required value="{{ $user->birth_date }}">
                                        </div>
                                      </div>
                                      <button class="btn btn-success mt-3">Save changes</button>
                                  </form>
                            </div>
                            <div class="tab-pane fade" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                                <span class="card-title text-bold"><h4>My addresses</h4></span>
                                <button class="btn btn-outline-secondary float-right"  data-toggle="modal" data-target="#add-address-modal">
                                    <i class="fas fa-plus"></i>
                                     Add new address
                                    </button>
                                <p class="card-text"><hr></p>
                            
                                <div class="addresses-main-container">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">...</div>
                          </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.modals')
    
  <!-- /.content-wrapper -->

@include('footer')

<script src="{{asset('js/customer/account.js')}}"></script>