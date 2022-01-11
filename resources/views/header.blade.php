<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($page_title) ? $page_title : 'Bioskin Philippines' }}</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('css/custom.css?v=' . strtotime('now')) }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="icon" href="{{ asset('/images/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('plugins/choices.min.css?version=3.0.3') }}">
    <script src="{{ asset('plugins/choices.min.js?version=3.0.3') }}"></script>
    @if (isset($page_title) && strpos($page_title, 'Login') !== false)
        <link rel="stylesheet" href="{{ asset('css/login.css?v=' . strtotime('now')) }}">
    @endif
    <style>
        body {
            font-family: "Karla", sans-serif;
            background-color: #E2E6EA !important;
            min-height: 100vh;
        }

        .content-wrapper,
        .wrapper {
            background-color: #FFF;
        }

    </style>
</head>

<body class="hold-transition layout-top-nav layout-navbar-fixed">
    <div class="wrapper">
