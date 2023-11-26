
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
<body class="bg-nuetral-100">
	<div class="flex justify-between">
		<div>
			<i class="fa fa-shapes"></i> 
			Base de datos	
		</div>

		<div>
			<select id="type" class="mr-5">
				<option value=""></option>
				<option value="command">Comandos</option>
				<option value="database">Base de datos</option>
				<option value="email">Correo electrónico</option>
				<option value="notification">Notificaciones</option>
				<option value="request">Solicitudes</option>
			</select>

			<a href="/monitor/delete/database" title="Eliminar datos">
				<i class="fa fa-trash"></i>
			</a>
		</div>
	</div>

	<div class="bg-white m-5 rounded">
		<table class="min-w-full text-left">
			<thead class="border-b">
				<tr class="border-b">
					<th class="px-6 py-4">#</th>
					<th class="px-6 py-4">Consulta</th>
					<th class="px-6 py-4">Duración</th>
					<th class="px-6 py-4">Tiempo</th>
					<th class="px-6 py-4"></th>
				</tr>
			</thead>

			<tbody>
				@foreach($items as $item)
					<tr class="border-b">
						<td class="px-6 py-4">{{ $loop->iteration }}</td>

						<td class="px-6 py-4 text-red-500">{{ $item->content->query }}</td>
						<td class="px-6 py-4">{{ $item->content->duration }}</td>

						<td class="px-6 py-4">{{ carbon()->create($item->content->time)->diffForHumans() }}</td>

						<td class="px-6 py-4">
							<a title="Ver detalles" href="{{ '/monitor/command/' . $item->id }}">
								<i class="fa fa-eye"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>	
</body>
</html>