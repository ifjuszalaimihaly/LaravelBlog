@extends('main')

@section('title', ' - Edit Blog Post')

@section('stylesheets')
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
	{!! Form::model($post, ['method' => "PUT" ,'route' => ['posts.update', $post->id], 'files' => true]) !!}
	<div class="col-md-8">	
		{{ Form::label('title', 'Title:') }}	
		{{ Form::text('title', null, ["class" => "form-control input-lg"]) }}
		{{ Form::label('body', 'Body:', ["class" => "form-spacing-top"]) }}			
		{{ Form::textarea('body', null, ["class" => "form-control"]) }}
		{{--{{ Form::label('featured_image', 'Upload featured image:') }}
				{{ Form::file('featured_image') }} --}}

		<label for="category_id" class="form-spacing-top">Category:</label>
		<select id="category_id" name="category_id" class="form-control">
			@foreach ($categories as $category)
			<option value="{{ $category->id }}">
				{{ $category->name }}
			</option>
			@endforeach
		</select>

		<label for="tag_id" class="form-spacing-top">Tags:</label>
		<select name="tags[]" id="tags" class="form-control select2-multi" multiple="multiple">
			@foreach ($tags as $tag)
			<option value="{{ $tag->id }}">
				{{ $tag->name }}
			</option>
			@endforeach
		</select>
		
	</div>
	<div class="col-md-4">
		<div class="well">
			<dl class="dl-horizontal">
				<dt>Created at:</dt>
				<dd>{{ date('M j Y H:j',strtotime($post->created_at)) }}</dd>
				<dt>Last updated at:</dt>
				<dd>{{ date('M j Y H:j',strtotime($post->updated_at)) }}</dd>
			</dl>
			<hr>
			<div class="row">
				<div class="col-md-6">
					{!! Html::linkRoute('posts.show' ,'Cancel', array($post->id), array('class' => 'btn btn-danger btn-block')) !!}
				</div>
				<div class="col-md-6">
					{{ Form::submit('Save Changes', array('class' => 'btn btn-success btn-block')) }}
				</div>				
			</div>
		</div>
		{!! Form::close() !!}
	</div>
	@endsection

	@section('scripts')
	{!! Html::script('js/select2.full.js') !!}
	<script type="text/javascript">
		$('.select2-multi').select2();
		$('.select2-multi').select2().val({{ json_encode($post->tags->pluck('id')) }}).trigger('change');
	</script>
	@endsection