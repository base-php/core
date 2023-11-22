
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
		<h1>Correos electrónicos</h1>

		<table class="auto">
			<thead>
				<tr>
					<th>#</th>
					<th>Clase</th>
					<th>Tiempo</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach($items as $item)
					<tr>
						<td>{{ $loop->iteration }}</td>

						<td>
							{{ $item->content->class }} <br>
							<small class="text-neutral-300">{{ $item->content->subject }}</small>
						</td>

						<td>{{ carbon()->create($item->content->time)->diffForHumans() }}</td>

						<td>
							<a href="{{ '/email/' . $item->id }}">
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