@if(errors())
	<div class="alert alert-danger mb-2">
		@foreach(errors() as $error)
			<li>{{ error($error) }}</li>
		@endforeach
	</div>
@else
	@if(messages('error'))
	    <div class="alert alert-danger mb-2">{{ message('error') }}</div>
	@endif

	@if(messages('info'))
		<div class="alert alert-success mb-2">{{ message('info') }}</div>
	@endif
@endif