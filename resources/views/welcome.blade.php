<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,600" rel="stylesheet">

        <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <h1 class="font-weight-bold mb-5">{{ config('app.name', 'Laravel') }}</h1>

            <a href="{{ route('login.spotify') }}" class="btn btn-spotify btn-lg rounded-pill shadow">
                <i class="fab fa-spotify"></i> Login with Spotify
            </a>

            <span class="d-block mb-4 mt-4">&mdash;</span>

            <div class="d-flex align-items-center">
                <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill shadow">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary rounded-pill shadow ml-2">Register</a>
            </div>
        </div>
    </body>
</html>
