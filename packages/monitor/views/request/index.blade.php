<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Monitor</title>

	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
	<div class="shadow bg-white rounded">
		<h1>Solicitudes</h1>

		<table class="auto">
			<thead>
				<tr>
					<th>#</th>
					<th>Método</th>
					<th>Ruta</th>
					<th>Estado</th>
					<th>Tiempo</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach($items as $item)
					<tr>
						<td>{{ $loop->iteration }}</td>

						<td>
							<span class="bg-neutral-300 p-3 rounded">
								{{ $item->content->method }}
							</span>
						</td>

						<td>{{ $item->content->path }}</td>

						<td>
							<span class="bg-neutral-300 p-3 rounded">
								{{ $item->content->status }}
							</span>
						</td>

						<td>{{ carbon()->create($item->content->time)->diffForHumans() }}</td>

						<td>
							<a href="{{ '/request/' . $item->id }}">
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
