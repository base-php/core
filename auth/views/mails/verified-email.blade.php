<!DOCTYPE html>
<html lang="{{ config('language') }}">
<head>
    <meta charset="{{ config('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            background-color: white;
        }
    </style>
</head>
<body>
    <h1 class="mb-5">
        <img src="http:{{ host() }}/resources/assets/img/app/favicon.ico" alt="">
        {{ config('application_name') }}
    </h1>

    <hr class="mb-5">

    <p>{{ lang('auth.email_greeting') }}, {{ $user->name }}.</p>

    <p>
        <a class="btn btn-primary" href="{{ host() }}/email-verified/{{ encrypt($user->id) }}">{{ lang('auth.email_verified') }}</a>
    </p>

    <hr class="mb-5">

    <p>{{ lang('auth.email_footer') }}: <a href="http:{{ host() }}/recover/{{ encrypt($user->id) }}">http:{{ host() }}/recover/{{ encrypt($user->id) }}</a></p>

    <script src="{{ node('jquery/dist/jquery.js') }}"></script>
    <script src="{{ node('bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
