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
				<h1>{{ $header ?? config('name') }}</h1>
			</td>
		</tr>

		<tr>
			<td width="50%">
				<strong>{{ config('name') }}</strong><br>

				@isset($street)
                    {{ $street }}<br>
                @endisset

                @isset($location)
                    {{ $location }}<br>
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

				{{ $bill->customer->name }}<br>

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

                @if ($bill->customer->email)
                    {{ $bill->customer->email }}<br>
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
						<th align="right">Impuesto</th>
						<th align="right">Monto</th>
					</tr>

					@foreach($bill->items() as $item)
						<tr class="row">
							<td>{{ $item->description }}</td>
							<td>{{ $item->quantity }}</td>
							<td>{{ $item->price }}</td>
							<td>{{ $item->tax }}</td>
							<td>{{ $item->amount }}</td>
						</tr>
					@endforeach
				</table>
			</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="3">Subtotal</td>
			<td align="right">{{ $bill->subtotal }}</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="3" align="right">Descuento</td>
			<td align="right">{{ $bill->discount }}</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="3" align="right">Impuesto</td>
			<td align="right">{{ $bill->tax }}</td>
		</tr>
	</table>
</body>
</html>