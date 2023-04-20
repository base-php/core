@if(errors())
	<div class="alert alert-danger">
		@foreach(errors() as $error)
			<li>{{ error($error) }}</li>
		@endforeach
	</div>
@else
	@if(messages('error'))
	    <div class="alert alert-danger">{{ message('error') }}</div>
	@endif

	@if(messages('info'))
		<div class="alert alert-success">{{ message('info') }}</div>
	@endif
@endif