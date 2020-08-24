<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

</head>
<body>
<div id="app">
    @guest
        @yield('content')
    @endguest
    @auth
        @csrf
        <top-bar></top-bar>
        <toast-notification></toast-notification>
        <div class="pt-16 flex">
            <div class="flex-1">
{{--                <router-view :key="$route.fullPath"></router-view>--}}
                @yield('content')
            </div>
        </div>
    @endauth

</div>
</body>
</html>
{{--<script>--}}
{{--    import TopBar from "../../js/components/layouts/TopBar";--}}
{{--    export default {--}}
{{--        components: {TopBar}--}}
{{--    }--}}
{{--</script>--}}
