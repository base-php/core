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
<link rel="stylesheet" href="{{ node('sweetalert2/dist/sweetalert2.css') }}">

<style>
    body {
        background-color: #F3F4F6;
    }

    .img-navbar {
        width: 30px;
        border-radius: 15px;
    }

    .link-profile, .link-profile:hover {
        color: black;
        text-decoration: none;
    }

    .img-photo {
        width: 170px;
        border-radius: 170px;
    }

    .img-profile-list {
        width: 30px;
        border-radius: 30px;
    }
</style>

</head>

<body>
    <nav class="navbar bg-white navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand" href="/dashboard"><i class="fa fa-shapes"></i> {{ config('application_name') }}</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {{ $active == 'home' ? 'active' : '' }}" href="/dashboard">{{ lang('Home') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $active == 'users' ? 'active' : '' }}" href="/dashboard/users">{{ lang('Users') }}</a>
                </li>
            </ul>

            <a class="link-profile" href="{{ '/dashboard/users/edit/' . auth()->id }}">
                <img class="img-navbar" src="{{ auth()->photo }}" alt="Avatar of User"> 
                {{ auth()->name }}
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            {{ $slot }}
        </div>
    </div>    

    <input type="hidden" id="confirm_delete_text" value="{{ lang('Are you sure you want to delete?') }}">
    <input type="hidden" id="confirm_delete_accept" value="{{ lang('Accept') }}">
    <input type="hidden" id="confirm_delete_cancel" value="{{ lang('Cancel') }}">

    <script src="{{ node('jquery/dist/jquery.js') }}"></script>
    <script src="{{ node('sweetalert2/dist/sweetalert2.js') }}"></script>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
