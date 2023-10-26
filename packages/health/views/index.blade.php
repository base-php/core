<!DOCTYPE html>
<html lang="{{ config('language') }}">

<head>

<meta charset="{{ config('charset') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Nisa Delgado">
<meta name="theme-color" content="#212529">

<title>{{ config('application_name') }}</title>

<link rel="icon" href="{{ asset('img/favicon.svg') }}">

<link rel="stylesheet" href="{{ node('@fortawesome/fontawesome-free/css/all.css') }}">

<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        background-color: silver;
    }
</style>

</head>

<body class="bg-[#f3f4f6]">
    <div class="text-center mx-32">
        <header class="mt-5">
            <h1>
                <div>
                    Health    
                </div>

                <i class="fa-solid fa-wave-square"></i>
            </h1>
        </header>

        <div class="flex mt-5">
            @foreach($items as $item)
                <div class="w-1/3 m-1 bg-white text-center p-3 rounded-md m-5">
                    <div>
                        <i class="fa fa-check bg-green-700 p-2 rounded-full text-white"></i>

                        {{ $item[0] }}
                    </div>

                    <div>{{ $item[1] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
