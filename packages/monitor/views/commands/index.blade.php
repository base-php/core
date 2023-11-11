<div class="shadow bg-white rounded">
	<h1>Comandos</h1>

	<table class="auto">
		<thead>
			<tr>
				<th>#</th>
				<th>Comando</th>
				<th>Tiempo</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			@foreach($requests as $request)
				<tr>
					<td>{{ $loop->iteration }}</td>

					<td>{{ $request->content['command'] }}</td>

					<td>{{ carbon()->create($request->content['time'])->diffForHumans() }}</td>

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