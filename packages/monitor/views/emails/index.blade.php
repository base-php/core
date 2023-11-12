<div class="shadow bg-white rounded">
	<h1>Correos electrónicos</h1>

	<table class="auto">
		<thead>
			<tr>
				<th>#</th>
				<th>Clase</th>
				<th>Tiempo</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			@foreach($emails as $email)
				<tr>
					<td>{{ $loop->iteration }}</td>

					<td>
						{{ $email->content['class'] }} <br>
						<small class="text-neutral-300">{{ $email->content['subject'] }}</small>
					</td>

					<td>{{ carbon()->create($email->content['time'])->diffForHumans() }}</td>

					<td>
						<a href="{{ '/email/' . $email->id }}">
							<i class="fa fa-eye"></i>
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>