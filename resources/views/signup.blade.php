@php
  $page_title =  "Signup | Bioskin";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  @include('includes.categories-menu')
  <style>
      .registration-container {
  background-color: #FFF;
  padding: 25px;
}
    .btn-primary {
      padding: 13px 20px 12px !important;
      border-radius: 4px !important;
      font-size: 17px !important;
      font-weight: bold !important;
      line-height: 20px !important;
      margin-bottom: 24px;
      border: 1px solid #3BC265 !important;
      background-color: transparent !important;
      color: #3BC265 !important; 
    }
    .btn-primary:hover {
      color: #fff !important;
      border-color: #3BC265 !important;
      background-color: #3BC265 !important;
    }

  </style>

  <main class="d-flex min-vh-100 py-3 py-md-0" style="margin-top: 50px;">
    <div class="container">
      <div class="card login-card">
        <div class="container registration-container">
            <div class="row py-5 ">
                <!-- For Demo Purpose -->
                <div class="col-md-5 pr-lg-5 mb-5 mb-md-0 ml-sm-0 ml-lg-5">
                    <img src="{{asset('images/undraw_fill_form_re_cwyf.svg')}}" alt="" class="img-fluid mb-3 d-none d-md-block">
                </div>
          
                <!-- Registeration Form -->
                <div class="col-md-7 col-lg-6 ml-auto">
                    
                  <h4 class="login-card-description">Create your account</h4>
                    <form action="{{ action('UserController@doSignup') }}" method="POST">
                      @csrf
                      @include('includes.alerts')
                        <div class="row">

                            <!-- First Name -->
                            <div class="input-group col-lg-6 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-user text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="firstname" placeholder="First Name" class="form-control bg-white border-left-0 border-md" required>
                            </div>
          
                            <!-- Last Name -->
                            <div class="input-group col-lg-6 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-user text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="lastname" placeholder="Last Name" class="form-control bg-white border-left-0 border-md" required>
                            </div>

                             <!-- Middle Name -->
                             <div class="input-group col-lg-6 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-user text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="middlename" placeholder="Middle Name" class="form-control bg-white border-left-0 border-md" required>
                            </div>

                             <!-- Username -->
                             <div class="input-group col-lg-6 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-user text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="username" placeholder="User Name" class="form-control bg-white border-left-0 border-md" required>
                            </div>
          
                            <!-- Email Address -->
                            <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-envelope text-muted"></i>
                                    </span>
                                </div>
                                <input id="email" type="email" name="email" placeholder="Email Address" class="form-control bg-white border-left-0 border-md" required>
                            </div>
          
                            <!-- Phone Number -->
                            <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-phone-square text-muted"></i>
                                    </span>
                                </div>
                                <input id="phoneNumber" type="tel" name="phone_no" placeholder="Phone Number" class="form-control bg-white border-md border-left-0 pl-3" required>
                            </div>
          
                            <!-- Password -->
                            <div class="input-group col-lg-6 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-lock text-muted"></i>
                                    </span>
                                </div>
                                <input id="password" type="password" name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md" autocomplete="new-password">
                            </div>
          
                            <!-- Password Confirmation -->
                            <div class="input-group col-lg-6 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-lock text-muted"></i>
                                    </span>
                                </div>
                                <input id="passwordConfirmation" type="password" placeholder="Confirm Password" class="form-control bg-white border-left-0 border-md">
                            </div>
                          
                              <!-- Submit Button -->
                              <div class="form-group col-lg-12 mx-auto mb-0">
                                <button type="submit" class="btn btn-primary btn-block py-2">
                                    <span class="font-weight-bold">Create your account</span>
                                </button>
                              </div>
                            </div>
                            
                            <a target="_blank" href="{{ url('/terms-and-conditions') }}">Terms and conditions</a>
          
                            <!-- Divider Text 
                            <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                                <div class="border-bottom w-100 ml-5"></div>
                                <span class="px-2 small text-muted font-weight-bold text-muted">OR</span>
                                <div class="border-bottom w-100 mr-5"></div>
                            </div>
          
                             Social Login
                            <div class="form-group col-lg-12 mx-auto">
                                <a href="#" class="btn btn-primary btn-block py-2 btn-facebook">
                                    <i class="fa fa-facebook-f mr-2"></i>
                                    <span class="font-weight-bold">Continue with Facebook</span>
                                </a>
                                <a href="#" class="btn btn-primary btn-block py-2 btn-twitter">
                                    <i class="fa fa-twitter mr-2"></i>
                                    <span class="font-weight-bold">Continue with Twitter</span>
                                </a>
                            </div>-->
          
                            <!-- Already Registered -->
                            <div class="w-100 mt-3">
                                <p class="text-muted">Already Registered? <a href="{{ url('/login') }}" class="text-primary ml-2">Login</a></p>
                            </div>
          
                        </div>
                    </form>
                </div>
            </div>
          </div>
      </div>
    </div>
  </main>
  <!-- /.content-wrapper -->

@include('footer')


<script>
    // For Demo Purpose [Changing input group text on focus]
  $(function () {
    $('input, select').on('focus', function () {
        $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
    });
    $('input, select').on('blur', function () {
        $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
    });
  
    $('[name="phone_no"]').on('keyup', function(evt) {
        forceNumeric($(this));
    });

    function forceNumeric(v){
        var $input = v;
        $input.val($input.val().replace(/[^\d]+/g,''));
    }
  
  $('#passwordConfirmation').on('blur', function () { 
    var password = $('#password').val();
    var confirm_password = $(this).val();
    if(confirm_password.replace(/ /g,'').length >= 6){
              if(password == confirm_password){
                  return true;
              }
              else{
                  alert('Password do not match!');
              }
          }
          else{
              alert('Minimum of 6 characters!')
          }
      
    });
  });
  
  </script>