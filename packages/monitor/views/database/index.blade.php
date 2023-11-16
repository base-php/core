<div class="shadow bg-white rounded">
	<h1>Consultas a base de datos</h1>

	<table class="auto">
		<thead>
			<tr>
				<th>#</th>
				<th>Consulta</th>
				<th>Duración</th>
				<th>Tiempo</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			@foreach($items as $item)
				<tr>
					<td>{{ $loop->iteration }}</td>

					<td class="text-red-500">{{ $item->content->query }}</td>
					<td>{{ $item->content->duration }}</td>

					<td>{{ carbon()->create($item->content->time)->diffForHumans() }}</td>

					<td>
						<a href="{{ '/command/' . $item->id }}">
							<i class="fa fa-eye"></i>
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>