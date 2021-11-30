@php
  $page_title =  "Bioskin";
@endphp


<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ isset($page_title) ? $page_title : "Bioskin Philippines" }}</title>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('css/custom.css?v='.strtotime("now"))}}">
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="icon" href="{{ asset('/images/logo.png') }}" type="image/x-icon"/>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/login.css?v='.strtotime("now"))}}">
  <style>
    .content-wrapper {
      background-color: #FFF;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav layout-navbar-fixed">
<div class="wrapper">
    

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters mb-3">
          <div class="col-md-5">
            <img src="{{ asset('images/bs_dr_bgn.png')  }}" alt="login" class="login-card-img m-4">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end footer-link text-small">
              Free <a href="https://www.bootstrapdash.com/" target="_blank" class="text-white">Bootstrap dashboard templates</a> from Bootstrapdash
            </p>
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <!--<img src="{{ asset('images/logo.png')  }}" alt="logo" class="logo">-->
              </div>
              <p class="login-card-description">Sign into your account</p>
              <form action="#!">
                  <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                  </div>
                  <input name="login" id="login" class="btn btn-block login-btn mb-4" type="button" value="Login">
                </form>
                <a href="#!" class="forgot-password-link">Forgot password?</a>
                <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
                <nav class="login-card-footer-nav">
                  <a href="#!">Terms of use.</a>
                  <a href="#!">Privacy policy</a>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- /.content-wrapper -->

@include('footer')

