<div class="shadow bg-white rounded">
	<h1>Detalles de notificación</h1>

	<div>
		<div>
			<div class="w-1/4">Fecha y hora</div>
			<div class="w-3/4">{{ $item->content->datetime }} ({{ carbon()->create($item->content->time)->diffForHumans() }})</div>
		</div>

		<div>
			<div class="w-1/4">Servidor</div>
			<div class="w-3/4">{{ $item->content->hostname }}</div>
		</div>

		<div>
			<div class="w-1/4">Canal</div>
			<div class="w-3/4">{{ $item->content->channel }}</div>
		</div>

		<div>
			<div class="w-1/4">Clase</div>
			<div class="w-3/4">{{ $item->content->class }}</div>
		</div>

		<div>
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