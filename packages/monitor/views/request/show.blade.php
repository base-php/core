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
	<h1 class="mx-6 py-4 text-4xl font-semibold">
		<div class="flex justify-between">
			<div>
				<i class="fa fa-shapes"></i> 
				Detalles de la solicitud
			</div>

			<div>
				<a href="/monitor/request">
					<i class="fa fa-arrow-left"></i>
				</a>
			</div>
		</div>
	</h1>

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
				<div class="w-1/4">Método</div>
				<div class="w-3/4">
					<span class="bg-neutral-300 rounded p-1">
						{{ $item->content->method }}
					</span>
				</div>
			</div>

			<div class="flex m-5">
				<div class="w-1/4">Ruta</div>
				<div class="w-3/4">{{ $item->content->path }}</div>
			</div>

			<div class="flex m-5">
				<div class="w-1/4">Estado</div>
				<div class="w-3/4">
					<span class="bg-{{ $item->content->status == 200 ? 'green' : 'red' }}-300 p-1 rounded">
						{{ $item->content->status }}
					</span>
				</div>
			</div>

			<div class="flex m-5">
				<div class="w-1/4">Duracíón</div>
				<div class="w-3/4">{{ $item->content->duration }}</div>
			</div>
		</div>

		<hr>

		<div class="m-5">
			<h4>Cuerpo de la solicitud</h4>

			<pre class="bg-slate-800 text-white">
				<code>
					{!! json($item->content->body) !!}
				</code>
			</pre>
		</div>

		<div class="m-5">
			<h4>Encabezados</h4>

			<pre class="bg-slate-800 text-white">
				<code>
					{!! json($item->content->headers) !!}
				</code>
			</pre>
		</div>

		<div class="m-5">
			<h4>Variables en sesión</h4>

			<pre class="bg-slate-800 text-white">
				<code>
					{!! json($item->content->session) !!}
				</code>
			</pre>
		</div>
	</div>
</body>
</html>
