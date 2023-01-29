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
	$class->filterContainer = $class->filterContainer ?? '';
	$class->filter = $class->filter ?? '';

	$style->table = $style->table ?? '';
	$style->thead = $style->thead ?? '';
	$style->tr = $style->tr ?? '';
	$style->th = $style->th ?? '';
	$style->tbody = $style->tbody ?? '';
	$style->td = $style->td ?? '';
	$style->img = $style->img ?? '';
	$style->widgetContainer = $style->widgetContainer ?? '';
	$style->tableContainer = $style->tableContainer ?? '';
	$style->filterContainer = $style->filterContainer ?? '';
	$style->filter = $style->filter ?? '';

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

		@if($filters)
			<div class="{{ $class->filterContainer }}" style="{{ $style->filterContainer }}">
				@foreach($filters as $filter)
					<div class="{{ $class->filter }}" style="{{ $style->filter }}">
						@if($filter->type = 'text')
							<label for="{{ $filter['name'] }}">{{ $filter['label'] }}</label>
							<input type="text" name="{{ $filter['name'] }}" id="{{ $filter->id }}" class="{{ $class->filterInput }}" style="{{ $style->filterInput }}">
						@endif

						@if($filter->type = 'date')
							<label for="{{ $filter['name'] }}">{{ $filter['label'] }}</label>
							<input type="date" name="{{ $filter['name'] }}" id="{{ $filter->id }}" class="{{ $class->filterInput }}" style="{{ $style->filterInput }}">
						@endif

						@if($filter->type = 'select')
							<label for="{{ $filter['name'] }}">{{ $filter['label'] }}</label>
							<select name="{{ $filter['name'] }}" id="{{ $filter->id }}" class="{{ $class->filterInput }}" style="{{ $style->filterInput }}">
								<option value=""></option>
								@foreach($filter['options'] as $item)
									<option value="{{ $item->value }}">{{ $item->label }}</option>
								@endforeach
							</select>
						@endif
					</div>
				@endforeach
			</div>
		@endif

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

		@if($footer)
			@include($footer->view, $footer->data)
		@endif
	</div>
@endif
