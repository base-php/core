<div class="shadow bg-white rounded">
	<h1>Solicitudes</h1>

	<table class="auto">
		<thead>
			<tr>
				<th>#</th>
				<th>Método</th>
				<th>Ruta</th>
				<th>Estado</th>
				<th>Tiempo</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			@foreach($requests as $request)
				<tr>
					<td>{{ $loop->iteration }}</td>

					<td>
						<span class="bg-neutral-300 p-3 rounded">
							{{ $request->content->method }}
						</span>
					</td>

					<td>{{ $request->content->path }}</td>

					<td>
						<span class="bg-neutral-300 p-3 rounded">
							{{ $request->content->status }}
						</span>
					</td>

					<td>{{ carbon()->create($request->content->time)->diffForHumans() }}</td>

					<td>
						<a href="{{ '/request/' . $request->id }}">
							<i class="fa fa-eye"></i>
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>