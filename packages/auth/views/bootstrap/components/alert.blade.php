@if(errors())
	<div class="alert alert-danger mt-4">
		@foreach(errors() as $error)
			<li>{{ error($error) }}</li>
		@endforeach
	</div>
@else
	@if(messages('error'))
	    <div class="alert alert-danger mt-4">{{ message('error') }}</div>
	@endif

	@if(messages('info'))
		<div class="alert alert-success mt-4">{{ message('info') }}</div>
	@endif
@endif