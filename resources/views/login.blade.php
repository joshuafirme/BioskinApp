@php
$page_title = 'Login | Bioskin';
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

@include('includes.categories-menu')

<main class="d-flex min-vh-100 py-3 py-md-0">
    <div class="container">
        <div class="card login-card" style="margin-top: 50px;">
            <div class="row no-gutters mb-3">
                <div class="col-md-5" style="margin-top:-50px;">
                    <img src="{{ asset('images/bs_dr_bgn.png') }}" alt="login"
                        class="login-card-img m-4 d-none d-md-block">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <div class="brand-wrapper">
                            <img src="{{ asset('images/logo.png') }}" alt="logo" class="logo d-block d-md-none">
                        </div>
                        <h4 class="login-card-description">Welcome to Bioskin!</h4>
                        <p>Sign into your account</p>
                        <form action="{{ action('UserController@doLogin') }}" method="POST">
                            @csrf
                            @include('includes.alerts')
                            <div class="row">
                                <div class="input-group col-12 mt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white px-4 border-md border-right-0">
                                            <i class="fa fa-user text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="email" placeholder="Email"
                                        class="form-control bg-white border-left-0 border-md" required>
                                </div>
                                <div class="input-group col-12 mt-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white px-4 border-md border-right-0">
                                            <i class="fa fa-lock text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" placeholder="Password"
                                        class="form-control bg-white border-left-0 border-md" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block login-btn mt-4 mb-4" type="button">Login</button>
                        </form>
                        <!--  <a href="#!" class="forgot-password-link">Forgot password?</a> -->
                        <p class="login-card-footer-text">Don't have an account? <a href="{{ url('/signup') }}"
                                class="text-reset">Register here</a></p>
                        <a target="_blank" href="{{ url('/terms-and-conditions') }}">Terms and conditions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- /.content-wrapper -->

@include('footer')

<script>
    $(function() {
        $('input, select').on('focus', function() {
            $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
        });
        $('input, select').on('blur', function() {
            $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
        });
    });
</script>
