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
<body x-data="app()" class="bg-neutral-100">
	<div class="flex justify-between text-4xl py-6 mx-4">
		<div>
			<i class="fa fa-shapes"></i> 
			Solicitudes	
		</div>

		<div>
			<select id="type" x-on:change="reloadWithType()" class="mr-5">
				<option value=""></option>
				<option value="command">Comandos</option>
				<option value="database">Base de datos</option>
				<option value="email">Correo electrónico</option>
				<option value="jobs">Trabajos en segundo plano</option>
				<option value="notification">Notificaciones</option>
				<option value="request">Solicitudes</option>
			</select>

			<a href="/monitor/delete/request" title="Eliminar datos">
				<i class="fa fa-trash"></i>
			</a>
		</div>
	</div>

	<div class="bg-white m-5 rounded">
		<table class="min-w-full text-left">
			<thead class="border-b">
				<tr class="border-b">
					<th class="px-6 py-4">#</th>
					<th class="px-6 py-4">Método</th>
					<th class="px-6 py-4">Ruta</th>
					<th class="px-6 py-4">Estado</th>
					<th class="px-6 py-4">Tiempo</th>
					<th class="px-6 py-4"></th>
				</tr>
			</thead>

			<tbody>
				@foreach($items as $item)
					<tr class="border-b">
						<td class="px-6 py-4">{{ $loop->iteration }}</td>

						<td class="px-6 py-4">
							<span class="bg-neutral-300 p-3 rounded">
								{{ $item->content->method }}
							</span>
						</td>

						<td class="px-6 py-4">{{ $item->content->path }}</td>

						<td class="px-6 py-4">
							<span class="bg-neutral-300 p-3 rounded">
								{{ $item->content->status }}
							</span>
						</td>

						<td class="px-6 py-4">{{ carbon()->create($item->content->time)->diffForHumans() }}</td>

						<td class="px-6 py-4">
							<a title="Ver detalles" href="{{ '/monitor/request/' . $item->id }}">
								<i class="fa fa-eye"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<script src="//unpkg.com/alpinejs" defer></script>
	<script src="/vendor/base-php/core/packages/monitor/js/main.js"></script>
</body>
</html>
