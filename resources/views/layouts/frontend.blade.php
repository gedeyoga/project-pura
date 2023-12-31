<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset(mix('css/app-frontend.css')) }}" rel="stylesheet">
</head>

<body>
    <div id="app">
    </div>

    @routes

    <!-- Scripts -->
    <!-- <script src="{{ asset(mix('js/app-frontend.js')) }}" defer></script>
    <script src="{{ asset(mix('js/app-frontend-vendor.js')) }}" defer></script> -->
    <script defer src="{{mix('/js/manifest.js')}}"></script>
    <script defer src="{{mix('/js/vendor.js')}}"></script>
    <script defer src="{{mix('/js/app-frontend.js')}}"></script>
</body>

</html>