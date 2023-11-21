<div class="shadow bg-white rounded">
	<h1>Detalles del comando</h1>

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
			<div class="w-1/4">Comando</div>
			<div class="w-3/4">{{ $item->content->command }}</div>
		</div>
	</div>

	<hr>

	<div>
		<h4>Argumentos</h4>

		<pre class="bg-slate-800 text-white">
			<code>
				{!! $item->content->arguments !!}
			</code>
		</pre>
	</div>

	<div>
		<h4>Opciones</h4>

		<pre class="bg-slate-800 text-white">
			<code>
				{!! $item->content->options !!}
			</code>
		</pre>
	</div>
</div>