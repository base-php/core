<!DOCTYPE html>
<html lang="{{ config('language') }}">
<head>

<meta charset="{{ config('charset') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Nisa Delgado">
<meta name="theme-color" content="#212529">

<title>{{ config('application_name') }}</title>

<link rel="icon" href="{{ asset('img/favicon.ico') }}">

<link rel="stylesheet" href="{{ node('@tailwindcss/forms/dist/forms.css') }}">
<link rel="stylesheet" href="{{ node('@fortawesome/fontawesome-free/css/all.css') }}">

<script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
	<div class="text-center">
		<h1 class="text-4xl mt-20">404</h1>
	</div>
</body>
</html>
