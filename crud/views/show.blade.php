@php
	$class->tableContainer = $class->tableContainer ?? '';
	$class->table = $class->table ?? '';
	$class->tbody = $class->tbody ?? '';
	$class->th = $class->th ?? '';
	$class->td = $class->td ?? '';

	$style->tableContainer = $style->tableContainer ?? '';
	$style->table = $style->table ?? '';
	$style->tbody = $style->tbody ?? '';
	$style->th = $style->th ?? '';
	$style->td = $style->td ?? '';
@endphp


@if($header)
	@include($header['view'], $header['data'])
@endif


<div class="{{ $class->tableContainer }}" style="{{ $style->tableContainer }}">
	@if($item)
		<table style="{{ $style->table }}" class="{{ $class->table }}">
			<tbody style="{{ $style->tbody }}" class="{{ $class->tbody }}">
				@foreach($fields as $field)
					<th style="{{ $style->th }}" class="{{ $class->th }}">{{ $field }}</th>
					<td style="{{ $style->td }}" class="{{ $class->td }}">{{ $item->$field }}</td>
				@endforeach
			</tbody>
		</table>
	@endif
</div>


@if($footer)
	@include($footer['view'], $footer['data'])
@endif