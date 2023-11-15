<div class="shadow bg-white rounded">
	<h1>Detalles de la solicitud</h1>

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
			<div class="w-1/4">Método</div>
			<div class="w-3/4">
				<span class="bg-neutral-300 rounded p-3">
					{{ $item->content->method }}
				</span>
			</div>
		</div>

		<div>
			<div class="w-1/4">Ruta</div>
			<div class="w-3/4">{{ $item->content->path }}</div>
		</div>

		<div>
			<div class="w-1/4">Estado</div>
			<div class="w-3/4">
				<span class="bg-{{ $item->content->status == 200 ? 'green' : 'red' }}-300 p-3 rounded">
					{{ $item->content->status }}
				</span>
			</div>
		</div>

		<div>
			<div class="w-1/4">Duracíón</div>
			<div class="w-3/4">{{ $item->content->duration }}</div>
		</div>
	</div>

	<hr>

	<div>
		<h4>Cuerpo de la solicitud</h4>

		<pre class="bg-slate-800 text-white">
			<code>
				{!! $item->content->body !!}
			</code>
		</pre>
	</div>

	<div>
		<h4>Encabezados</h4>

		<pre class="bg-slate-800 text-white">
			<code>
				{!! $item->content->headers !!}
			</code>
		</pre>
	</div>

	<div>
		<h4>Variables en sesión</h4>

		<pre class="bg-slate-800 text-white">
			<code>
				{!! $item->content->session !!}
			</code>
		</pre>
	</div>
</div>