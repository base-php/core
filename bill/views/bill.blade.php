<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Factura</title>

	<style>
		table {
			width: 100%;
		}

		body {
            background: #fff none;
            font-family: DejaVu Sans, 'sans-serif';
            font-size: 12px;
        }

        .table th {
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding: 8px 8px 8px 0;
            vertical-align: bottom;
        }

        .table tr.row td {
            border-bottom: 1px solid #ddd;
        }

        .table td {
            padding: 8px 8px 8px 0;
            vertical-align: top;
        }

        .table th:last-child,
        .table td:last-child {
            padding-right: 0;
        }
	</style>
</head>
<body>
	<table>
		<tr>
			<td>
				<h3>Factura</h3>

				<p>
					<strong>Fecha:</strong> {{ $bill->date_create }}<br>

					<strong>Número factura:</strong> {{ $bill->id }}<br>
				</p>
			</td>

			<td align="right">
				<h1>{{ $header }}</h1>
			</td>
		</tr>

		<tr>
			<td width="50%">
				<strong>{{ config('name') }}</strong><br>

				@isset($address)
                    {{ $address }}<br>
                @endisset

                @isset($city)
                    {{ $city }}<br>
                @endisset

                @isset($state)
                    {{ $state }}<br>
                @endisset

                @isset($country)
                    {{ $country }}<br>
                @endisset

                @isset($phone)
                    {{ $phone }}<br>
                @endisset

                @isset($email)
                    {{ $email }}<br>
                @endisset

                @isset($url)
                    <a href="{{ $url }}">{{ $url }}</a><br>
                @endisset
			</td>

			<td width="50%">
				<strong>Cliente</strong><br>

				{{ $bill->name }}<br>

				@if ($bill->customer->address)
                    {{ $bill->customer->address }}<br>
                @endif

                @if ($bill->customer->city)
                    {{ $bill->customer->city }}<br>
                @endif

                @if ($bill->customer->state || $bill->customer->postal_code)
                    {{ implode(' ', [$bill->customer->state, $bill->customer->postal_code]) }}<br>
                @endif

                @if ($bill->customer->country)
                    {{ $bill->customer->country }}<br>
                @endif

                @if ($bill->customer->phone)
                    {{ $bill->customer->phone }}<br>
                @endif

                @if ($bill->email)
                    {{ $bill->email }}<br>
                @endif
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<table class="table" width="100%" border="0">
					<tr>
						<th align="left">Descripción</th>
						<th align="left">Cantidad</th>
						<th align="left">Precio unitario</th>

						@if($bill->tax)
							<th align="left">Impuesto</th>
						@endif

						@if($bill->discount)
							<th align="left">Descuento</th>
						@endif
					</tr>

					@foreach($bill->items as $item)
						<tr class="row">
							<td>{{ $item->description }}</td>
							<td>{{ $item->quantity }}</td>
							<td>{{ number_format($item->price, 2) }}</td>

							@if($bill->tax)
								<td>{{ number_format($item->tax, 2) }}</td>
							@endif

							@if($bill->discount)
								<td>{{ number_format($item->discount, 2) }}</td>
							@endif
						</tr>
					@endforeach
				</table>
			</td>
		</tr>

		@if($bill->tax || $bill->discount)
			<tr>
				<td></td>
				<th colspan="3" align="left">Subtotal</th>
				<td>{{ number_format($bill->subtotal, 2) }}</td>
			</tr>
		@endif

		@if($bill->discount)
			<tr>
				<td></td>
				<th colspan="3" align="left">Descuento</th>
				<td>{{ number_format($bill->discount, 2) }}</td>
			</tr>
		@endif

		@if($bill->discount)
			<tr>
				<td></td>
				<th colspan="3" align="left">Impuesto</th>
				<td>{{ number_format($bill->tax, 2) }}</td>
			</tr>
		@endif

		<tr>
			<td></td>
			<th colspan="3" align="left">Total</th>
			<td>{{ number_format($bill->total, 2) }}</td>
		</tr>
	</table>
</body>
</html>