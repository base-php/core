<div class="shadow bg-white rounded">
	<h1>Detalles de la consulta a base de datos</h1>

	<div>
		<div>
			<div class="w-1/4">Fecha y hora</div>
			<div class="w-3/4">{{ $item->content->datetime }}</div>
		</div>

		<div>
			<div class="w-1/4">Servidor</div>
			<div class="w-3/4">{{ $item->content->hostname }}</div>
		</div>

		<div>
			<div class="w-1/4">Duración</div>
			<div class="w-3/4">{{ $item->content->duration }}</div>
		</div>
	</div>

	<hr>

	<div>
		<h4>Consulta</h4>

		<pre class="bg-slate-800 text-white">
			<code>
				{!! $item->content->query !!}
			</code>
		</pre>
	</div>
</div>