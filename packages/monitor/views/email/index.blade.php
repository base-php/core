
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
	<h1 class="mx-6 py-4 text-4xl font-semibold">Correos electrónicos</h1>

	<div class="bg-white m-5 rounded">
		<table class="min-w-full text-left">
			<thead class="border-b">
				<tr class="border-b">
					<th class="px-6 py-4">#</th>
					<th class="px-6 py-4">Clase</th>
					<th class="px-6 py-4">Tiempo</th>
					<th class="px-6 py-4"></th>
				</tr>
			</thead>

			<tbody>
				@foreach($items as $item)
					<tr class="border-b">
						<td class="px-6 py-4">{{ $loop->iteration }}</td>

						<td class="px-6 py-4">
							{{ $item->content->class }} <br>
							<small class="text-neutral-300">{{ $item->content->subject }}</small>
						</td>

						<td class="px-6 py-4">{{ carbon()->create($item->content->time)->diffForHumans() }}</td>

						<td class="px-6 py-4">
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