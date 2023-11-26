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
				Detalles de la notificación
			</div>

			<div>
				<a title="Ir a atrás" href="/monitor/notification">
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
				<div class="w-1/4">Canal</div>
				<div class="w-3/4">{{ $item->content->channel }}</div>
			</div>

			<div class="flex m-5">
				<div class="w-1/4">Clase</div>
				<div class="w-3/4">{{ $item->content->class }}</div>
			</div>

			<div class="flex m-5">
				<div class="w-1/4">Destinatario</div>

				<div class="w-3/4">
					@if($item->content->recipient_email)
						{{ $item->content->recipient_email }}
					@else
						{{ $item->content->recipient_class . ':' . $item->content->recipient_id }}
					@endif
				</div>
			</div>
		</div>
	</div>	
</body>
</html>
