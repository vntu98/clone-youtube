<!DOCTYPE html>
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
    <script>
        window.codetube = {
            url: '{{ config('app.url') }}',
            user: {
                id: {{ Auth::check() ? Auth::user()->id : 1 }},
                authenticated: {{ Auth::check() ? 'true' : 'false' }}
            }
        }
    </script>
    <style>
        .video-placeholder {
            position: relative;
            background-color: #111;
            padding-top: 56.25%;
            width: 100%;
            max-width: 100%;
        }

        .video-laceholder__header {
            font-size: 14px;
            position: absolute;
            top: 50%;
            transform: translateX(-50%);
            left: 50%;
            color: #ccc;
        }
        .video__views {
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div id="app">
        
        @include('layouts.partials._navigation')

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
