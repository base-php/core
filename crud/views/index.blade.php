@php
	$class->table = $class->table ?? '';
	$class->thead = $class->thead ?? '';
	$class->tr = $class->tr ?? '';
	$class->th = $class->th ?? '';
	$class->tbody = $class->tbody ?? '';
	$class->td = $class->td ?? '';
	$class->img = $class->img ?? '';
	$class->widgetContainer = $class->widgetContainer ?? '';
	$class->tableContainer = $class->tableContainer ?? '';


	$style->table = $style->table ?? '';
	$style->thead = $style->thead ?? '';
	$style->tr = $style->tr ?? '';
	$style->th = $style->th ?? '';
	$style->tbody = $style->tbody ?? '';
	$style->td = $style->td ?? '';
	$style->img = $style->img ?? '';
	$style->widgetContainer = $style->widgetContainer ?? '';
	$style->tableContainer = $style->tableContainer ?? '';

	$buttons->show['class'] = $buttons->show['class'] ?? '';
	$buttons->show['text'] = $buttons->show['text'] ?? 'Ver';
	$buttons->show['icon'] = isset($buttons->show['icon']) ? '<span class="' . $buttons->show['icon'] . '"></span>' : '';

	$buttons->edit['class'] = $buttons->edit['class'] ?? '';
	$buttons->edit['text'] = $buttons->edit['text'] ?? 'Editar';
	$buttons->edit['icon'] = isset($buttons->edit['icon']) ? '<span class="' . $buttons->edit['icon'] . '"></span>' : '';

	$buttons->delete['class'] = $buttons->delete['class'] ?? '';
	$buttons->delete['text'] = $buttons->delete['text'] ?? 'Eliminar';
	$buttons->delete['icon'] = isset($buttons->delete['icon']) ? '<span class="' . $buttons->delete['icon'] . '"></span>' : '';
@endphp

@foreach($css as $item)
	<link rel="stylesheet" href="{{ $item }}">
@endforeach

@foreach($js as $item)
	<script src="{{ $item }}"></script>
@endforeach

@if($widgets)
	<div class="{{ $class->widgetContainer }}">
		@foreach($widgets as $widget)
			@include($widget['view'], $widget['data'] ?? null)
		@endforeach
	</div>
@endif

@if($items->count())
	<div class="{{ $class->tableContainer }}" style="{{ $style->tableContainer }}">
		<table style="{{ $style->table }}" class="{{ $class->table }}">
			<thead style="{{ $style->thead  }}" class="{{ $class->thead }}">
				<tr style="{{ $style->tr }}" class="{{ $class->tr }}">
					@foreach($fields as $field)
						<th style="{{ $style->th }}" class="{{ $class->th }}">{{ $field[0] }}</th>
					@endforeach

					<th style="{{ $style->th }}" class="{{ $class->th }}"></th>
				</tr>
			</thead>

			<tbody style="{{ $style->tbody }}" class="{{ $class->tbody }}">
				@foreach($items as $item)
					<tr style="{{ $style->tr }}" class="{{ $class->tr }}">
						@foreach($fields as $field)
							@php
								$key = $field[1];
							@endphp

							@if($field[2] == 'image')
								<td style="{{ $style->td }}" class="{{ $class->td }}">
									<img style="{{ $style->img }}" class="{{ $class->img }}" src="{{ $item->$key }}" alt="{{ $item->$key }}">
								</td>

							@else
								<td style="{{ $style->td }}" class="{{ $class->td }}">{{ $item->$key }}</td>
							@endif
						@endforeach

						<td style="{{ $style->td }}" class="{{ $class->td }}">
							<a href="" class="{{ $buttons->show['class'] }}">
								{!! $buttons->show['icon'] !!} {{ $buttons->show['text'] }}
							</a>

							<a href="" class="{{ $buttons->edit['class'] }}">
								{!! $buttons->edit['icon'] !!} {{ $buttons->edit['text'] }}
							</a>

							<a href="" class="{{ $buttons->delete['class'] }}">
								{!! $buttons->delete['icon'] !!} {{ $buttons->delete['text'] }}
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		@if(method_exists($items, 'links'))
			{{ $items->links($paginationView) }}
		@endif
	</div>
@endif
