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
		<h1>Comandos</h1>

		<table class="auto">
			<thead>
				<tr>
					<th>#</th>
					<th>Comando</th>
					<th>Tiempo</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach($items as $item)
					<tr>
						<td>{{ $loop->iteration }}</td>

						<td class="text-red-500">{{ $item->content->command }}</td>

						<td>{{ carbon()->create($item->content->time)->diffForHumans() }}</td>

						<td>
							<a href="{{ '/command/' . $item->id }}">
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