<!doctype html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset = "utf-8">
    <meta content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name = 'viewport'/>

    <!-- CSRF Token -->
    <meta name = "csrf-token" content = "{{ csrf_token() }}">

    <title>{{ config('app.name', 'CodingForKids') }}</title>

    <!-- Scripts -->
    <script src = "{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel = "dns-prefetch" href = "//fonts.gstatic.com">

    <!-- Styles -->
    <link href = "{{ asset('css/app.css') }}" rel = "stylesheet">
    <link href = "{{ asset('css/vue-multiselect.min.css') }}" rel = "stylesheet">
    <link href = "https://unpkg.com/element-ui/lib/theme-chalk/index.css" rel = "stylesheet">
    <script src = "https://kit.fontawesome.com/eddec21dc6.js"></script>
    <script src = "{{ asset('js/paper-dashboard.min.js') }}" defer></script>
    <!--===============================================================================================-->
    {{--<link rel = "stylesheet" type = "text/css" href = "css/login.css">
    <link rel = "stylesheet" type = "text/css" href = "css/login-util.css">
    <!-- Bootstrap -->
    <link type = "text/css" rel = "stylesheet" href = "css/bootstrap.min.css"/>
    <!-- Custom stlylesheet -->
    <link type = "text/css" rel = "stylesheet" href = "css/home-style.css"/>--}}
    <style>
        [v-cloak] {
            display : none;
        }
    </style>
</head>
<body>
<div id = "app" v-cloak>
    <app></app>
</div>
</body>
<script></script>
</html>
