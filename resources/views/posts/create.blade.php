@extends('main')
@section('title',' - Create New Post')
@section('stylesheets')
	{!! Html::style('css/parsley.css') !!}
	{!! Html::style('css/select2.min.css') !!}

	<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=58vhsltso3azsov51ddygvwz21bw8y1ck6nmpr78w1vsgch4"></script>
	<script>
		tinymce.init({
            selector: 'textarea',
            plugins: 'link code',
            menubar: false
        });﻿
	</script>
@endsection
@section('content')
	<div class="row">
		<div class="col-md-8 col-lg-offset-2">
			<h1>Create New Post</h1>
			<hr>
			{!! Form::open(array('route' => 'posts.store', 'data-parsley-validate' => '', 'files' => true, 'method' => 'POST')) !!}
    			{{ Form::label('title','Title:') }}
    			{{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

    			{{ Form::label('body','Body:') }}
    			{{ Form::textarea('body', null, array('class' => 'form-control')) }}

				{{--{{ Form::label('featured_image', 'Upload featured image:') }}
				{{ Form::file('featured_image') }} --}}

				{{ Form::label('category_id', 'Category:') }}
				
				<select name="category_id" id="category_id" class="form-control">
					@foreach ($categories as $category)
						<option value="{{ $category->id }}">{{ $category->name }}</option>	
					@endforeach
					
				</select>

				{{ Form::label('tags', 'Tags:') }}
				
				<select name="tags[]" id="tags" class="form-control select2-multi" multiple="multiple"><!-- [] tömbbe teszi az emelemeket--> 
					@foreach ($tags as $tag)
						<option value="{{ $tag->id }}">{{ $tag->name }}</option>	
					@endforeach
					
				</select>

    			{{   Form::submit('Create post', array('class' => 'btn btn-success bt-lg btn-block', 'style' => 'margin-top: 20px')) }}
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
	{!! Html::script('js/select2.full.js') !!}


	<script type="text/javascript">
		$('.select2-multi').select2();
	</script>
@endsection