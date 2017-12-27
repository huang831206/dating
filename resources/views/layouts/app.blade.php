<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>論友</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- custom css --}}
    @yield('style')
</head>
<body>
    @include('layouts.nav')

    <div id="app" class="ui bottom attached pushable" style='margin-top:60px;'>

        @include('layouts.sidebar')

        <div class="pusher" style="height:100%">
            @yield('content')

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('/js/manifest.js') }}"></script>
    <script src="{{ asset('/js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('script')
</body>
</html>
