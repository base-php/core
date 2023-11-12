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
			@foreach($commands as $command)
				<tr>
					<td>{{ $loop->iteration }}</td>

					<td class="text-red-500">{{ $command->content['command'] }}</td>

					<td>{{ carbon()->create($command->content['time'])->diffForHumans() }}</td>

					<td>
						<a href="{{ '/command/' . $command->id }}">
							<i class="fa fa-eye"></i>
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>