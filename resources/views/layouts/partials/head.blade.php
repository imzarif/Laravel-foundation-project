<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? config('app.name', 'VAS & NB Portal') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />
    <link href="{{ asset('assets/vendors/mdi/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/axios.js') }} "></script>
    @yield('page_css')
</head>

<body>
