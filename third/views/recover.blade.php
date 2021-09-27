<!DOCTYPE html>
<html lang="{{ config('language') }}">
<head>
    <meta charset="{{ config('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @php
            echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/node_modules/tailwindcss/dist/tailwind.css');
        @endphp

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

    <p>{{ __('auth.email_greeting') }}, {{ $user->name }}.</p>

    <p>{{ __('auth.text') }}</p>

    <p>
        <a class="btn btn-primary" href="{{ host() }}/recover/{{ md5($user->id) }}">{{ __('auth.email_recover_password') }}</a>
    </p>

    <p>{{ __('email.email_warning') }}</p>

    <p class="mb-5">{{ __('auth.email_fired') }}, {{ config('application_name') }}.</p>

    <hr class="mb-5">

    <p>{{ __('auth.email_footer') }}: <a href="http:{{ host() }}/recover/{{ md5($user->id) }}">http:{{ host() }}/recover/{{ md5($user->id) }}</a></p>

    <script src="{{ node('jquery/dist/jquery.js') }}"></script>
    <script src="{{ node('bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
