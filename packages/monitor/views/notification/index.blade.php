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
	<h1 class="mx-6 py-4 text-4xl font-semibold">Notificaciones</h1>

	<div class="bg-white m-5 rounded">
		<table class="min-w-full text-left">
			<thead class="border-b">
				<tr class="border-b">
					<th clas="px-6 py-4">#</th>
					<th clas="px-6 py-4">Notificación</th>
					<th clas="px-6 py-4">Canal</th>
					<th clas="px-6 py-4">Tiempo</th>
					<th clas="px-6 py-4"></th>
				</tr>
			</thead>

			<tbody>
				@foreach($items as $item)
					<tr class="border-b">
						<td class="px-6 py-4">{{ $loop->iteration }}</td>

						<td class="px-6 py-4">
							{{ $item->content->notification }}

							<small>
								Destino: 

								@if($item->content->recipient_email)
									{{ $item->content->recipient_email }}
								@else
									{{ $item->content->recipient_class . ':' . $item->content->recipient_id }}
								@endif
							</small>
						</td>

						<td class="px-6 py-4">{{ $item->content->channel }}</td>

						<td class="px-6 py-4">{{ carbon()->create($item->content->time)->diffForHumans() }}</td>

						<td class="px-6 py-4">
							<a href="{{ '/monitor/notification/' . $item->id }}">
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
