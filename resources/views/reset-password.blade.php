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
        @include('includes.alerts')
	    <div class="row justify-content-center">
	        <div class="col-lg-6 col-sm-12">   
                @if ($is_token_valid) 
	            <form class="card mt-4" action="{{action('UserController@resetPassword')}}" method="POST">
                    @csrf
	                <div class="card-body">
	                    <div class="form-group"> <label>Enter your new password</label> 
                            <input class="form-control" type="password" name="password" id="password" required="">
                        </div>
                        <button class="btn btn-success mt-2" type="submit">Reset Password</button> 
	                </div>
	            </form>
                @else 
                    <div class="alert alert-danger">
                        Sorry, this link to reset your password is not valid anymore. 
                        Please try to reset your password again <a href="{{url('/forgot-password')}}">here.</a></div>
                @endif
	        </div>
	    </div>
	</div>
    <!-- /.content-wrapper -->

    @include('footer')
