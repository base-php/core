<div class="shadow bg-white rounded">
	<h1>Detalles del correo electrónico</h1>

	<div>
		<div>
			<div class="w-1/4">Fecha y hora</div>
			<div class="w-3/4">{{ $email->content['datetime'] }}</div>
		</div>

		<div>
			<div class="w-1/4">Servidor</div>
			<div class="w-3/4">{{ $email->content['hostname'] }}</div>
		</div>

		<div>
			<div class="w-1/4">Clase</div>
			<div class="w-3/4">{{ $email->content['class'] }}</div>
		</div>

		<div>
			<div class="w-1/4">Origen</div>
			<div class="w-3/4">{{ $email->content['from'] }}</div>
		</div>

		<div>
			<div class="w-1/4">Destinatario</div>
			<div class="w-3/4">{{ $email->content['to'] }}</div>
		</div>

		<div>
			<div class="w-1/4">Asunto</div>
			<div class="w-3/4">{{ $email->content['subject'] }}</div>
		</div>
	</div>
</div>