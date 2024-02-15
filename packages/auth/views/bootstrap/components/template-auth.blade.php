<!DOCTYPE html>
<html lang="{{ config('language') }}">

<head>

<meta charset="{{ config('charset') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Nisa Delgado">
<meta name="theme-color" content="#212529">

<title>{{ config('application_name') }}</title>

<link rel="icon" href="{{ asset('img/favicon.svg') }}">

<link rel="stylesheet" href="{{ node('bootstrap/dist/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ node('@fortawesome/fontawesome-free/css/all.css') }}">

<style>
    body {
        background-color: silver;
    }
</style>

</head>

<body>
    <header class="mt-5 mb-5">
        <a href="/login" class="text-decoration-none">
            <h1 class="text-center text-dark">
                <i class="fa fa-shapes"></i> Base PHP
            </h1>
        </a>
    </header>

    <div class="container">
        {{ $slot }}
    </div>
</body>

</html>
