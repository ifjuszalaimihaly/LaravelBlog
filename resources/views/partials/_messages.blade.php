@if(Session::has('succes'))
	<div class="alert alert-success" role="alert">
		<strong>Success:</strong> {{ Session::get('succes') }}
	</div>
@endif

@if(count($errors) > 0)
	<div class="alert alert-danger">
		<strong>Errors:</strong>
		<ul>
		@foreach ($errors as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	</div>
@endif