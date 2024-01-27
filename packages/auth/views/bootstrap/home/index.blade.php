<!DOCTYPE html>
<html lang="{{ config('language') }}">

<head>

<meta charset="{{ config('charset') }}">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<meta name="author" content="Nisa Delgado">
<meta name="theme-color" content="#212529">

<title>{{ config('application_name') }}</title>

<link rel="icon" href="{{ asset('img/favicon.svg') }}">

<link rel="stylesheet" href="{{ node('@fortawesome/fontawesome-free/css/all.css') }}">
<link rel="stylesheet" href="{{ node('bootstrap/dist/css/bootstrap.css') }}">

</head>
<body>
    <div class="container mt-4">
        <h1>
            <i class="fa fa-shapes"></i> {{ config('application_name') }}
        </h1>

        <small>[Framework: {{ config('version') }} | PHP: {{ phpversion() }}]</small>

        <hr class="mb-5 mb-5">

        <div class="row mb-5">
            <div class="col-6">
                <p class="text-2xl">{{ lang('home.intro') }}</p>
            </div>
        </div>

        <hr class="mb-5 mb-5">

        <div class="row">
            @if(class_exists('App\Controllers\AuthController'))
                <div class="col-6">
                    <h2>{{ lang('home.explorer') }}</h2>

                    <div class="mt-5">
                        @if(auth())
                            <a href="/dashboard" class="text-decoration-none text-dark d-block">
                                <i class="fa fa-arrow-right"></i> {{ lang('Home') }}
                            </a>
                        @else
                            <a href="/login" class="text-decoration-none text-dark d-block">
                                <i class="fa fa-arrow-right"></i> {{ lang('home.login') }}
                            </a>

                            <a href="/register" class="text-decoration-none text-dark d-block">
                                <i class="fa fa-arrow-right"></i> {{ lang('home.register') }}
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <div class="col-6">
                <h2>{{ lang('home.info') }}</h2>

                <div class="mt-5 mb-5">
                    <a target="_blank" href="https://twitter.com/nisa6delgado" class="text-decoration-none text-dark d-block">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>

                    <a target="_blank" href="https://www.youtube.com/channel/UCTgu94owdYN98yBZQnW0ihA" class="text-decoration-none text-dark d-block">
                        <i class="fab fa-youtube"></i> Youtube
                    </a>

                    <a target="_blank" href="https://nisadelgado.com" class="text-decoration-none text-dark d-block">
                        <i class="fas fa-globe-americas"></i> {{ lang('home.web') }}
                    </a>

                    <a target="_blank" href="mailto:nisadelgado@gmail.com" class="text-decoration-none text-dark d-block">
                        <i class="fas fa-envelope"></i> {{ lang('home.email') }}
                    </a>
                </div>
            </div>
        </div>

        <hr class="mb-4 mt-4">

        <div class="text-center">
            <p>&copy; {{ now('Y') }}</p>
        </div>
    </div>
</body>
</html>
