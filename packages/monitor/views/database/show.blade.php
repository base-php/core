
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Monitor</title>

	<link rel="icon" href="{{ asset('img/favicon.svg') }}">

	<link rel="stylesheet" href="{{ node('@fortawesome/fontawesome-free/css/all.css') }}">

	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-100">
	<h1 class="mx-6 py-4 text-4xl font-semibold">Detalles de la consulta a base de datos</h1>

	<div class="bg-white m-5 rounded pb-5">
		<div class="w-full p-5">
			<div class="flex m-5">
				<div class="w-1/4">Fecha y hora</div>
				<div class="w-3/4">{{ $item->content->time }} ({{ carbon()->create($item->content->time)->diffForHumans() }})</div>
			</div>

			<div class="flex m-5">
				<div class="w-1/4">Servidor</div>
				<div class="w-3/4">{{ $item->content->hostname }}</div>
			</div>

			<div class="flex m-5">
				<div class="w-1/4">Duración</div>
				<div class="w-3/4">{{ $item->content->duration }}</div>
			</div>
		</div>

		<hr>

		<div class="m-5">
			<h4>Consulta</h4>

			<pre class="bg-slate-800 text-white">
				<code>
					{!! $item->content->query !!}
				</code>
			</pre>
		</div>
	</div>	
</body>
</html>