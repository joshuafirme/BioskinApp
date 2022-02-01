@php
$page_title = 'Forgot Password | Bioskin';
$categories = Utils::readCategories();
@endphp

@include('header')


<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div></div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="row pl-3 pr-3 pt-1 pb-1 category-container justify-content-center"
        style="margin-top: 11px; background-color: #EFF6EC;">
        @foreach ($categories as $item)
            <a class="p-1 ml-3 mr-3 text-center" href="{{ url('/shop/category/' . $item->id) }}">
                <div class="text-muted category-name" data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                    {{ $item->name }}</div>
            </a>
        @endforeach

    </div>

	<div class="container padding-bottom-3x mb-2 mt-5 mb-5">
	    <div class="row justify-content-center">
            @include('includes.alerts')
	        <div class="col-lg-8 col-md-10">
	            <div class="forgot">
	                <h2>Forgot your password?</h2>
	                <p>Change your password in three easy steps. This will help you to secure your password!</p>
	                <ol class="list-unstyled">
	                    <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
	                    <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
	                    <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
	                </ol>
	            </div>
	            <form class="card mt-4" action="{{action('UserController@sendResetPasswordLink')}}" method="POST">
                    @csrf
	                <div class="card-body">
	                    <div class="form-group"> <label for="email-for-pass">Enter your email address</label> 
                            <input class="form-control" type="email" name="email" id="email-for-pass" required="">
                            <small class="form-text text-muted">Enter the email address you used during the registration. Then we'll email a link to this address.</small> </div>
	                </div>
	                <div class="card-footer"> <button class="btn btn-success" type="submit">Get New Password</button> <a class="btn btn-danger" href="{{url('/login')}}">Back to Login</a> </div>
	            </form>
	        </div>
	    </div>
	</div>
    <!-- /.content-wrapper -->

    @include('footer')
