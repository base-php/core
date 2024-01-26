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

    <p>{{ lang('Hello') }}, {{ $user->name }}.</p>

    <p>{{ lang('You are receiving this email because you made a password recovery request for your account.') }}</p>

    <p>
        <a class="btn btn-primary" href="{{ host() }}/recover/{{ encrypt($user->id) }}">{{ lang('Recover password') }}</a>
    </p>

    <p>{{ lang('If you did not make this request, no action is required.') }}</p>

    <p class="mb-5">{{ lang('Greetings') }}, {{ config('application_name') }}.</p>

    <hr class="mb-5">

    <p>{{ lang('If you have problems clicking the \'Recover Password\' button, copy and paste the following URL into your web browser') }}: <a href="http:{{ host() }}/recover/{{ encrypt($user->id) }}">http:{{ host() }}/recover/{{ encrypt($user->id) }}</a></p>

    <script src="{{ node('jquery/dist/jquery.js') }}"></script>
    <script src="{{ node('bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
