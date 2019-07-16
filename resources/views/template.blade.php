<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />

    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <title>@yield('title') - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />

    <script src="{{ asset('js/require.min.js') }}"></script>
    <script>
        requirejs.config({
            baseUrl: '{{ asset('') }}'
        });
    </script>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/plugin.js') }}"></script>

    @yield('css')
</head>
<body class="">
<div class="page">
    <div class="page-main">
        @include('_header')
        @include('_menu')
        
        <div class="my-3 my-md-5">
            @yield('content')
        </div>
    </div>
    @include('_footer')
</div>

<script>
    // dynamic active class
    require(['jquery'], function( $ ) {
        let menu = $('#headerMenuCollapse');
        let rel = "{{ Request::segment(1) }}";

        if(!rel) rel = 'index';

        menu.find('.active').removeClass('active');
        menu.find('.nav-item[rel='+ rel +'] a').addClass('active');
    });
</script>
@yield('js')
</body>
</html>