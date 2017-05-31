@extends('main')
@section('title', ' - View Post')

@section('content')
<div class="row">
	<div class="col-md-8">		
		<h1>{{ $post->title }}</h1>
		<p class="lead">
			{!! $post->body !!}
		</p>
		
		<p class="leaad">
			Posted in: {{ $post->category->name }}
		</p>
		<hr>
		<div class="tags">
		@foreach ($post->tags as $tag)
			<span class="label label-default">
				{{ $tag->name }}
			</span>
		@endforeach
		</div>
		<div id="backend-comments" style="margin-top: 50px">
			<h3>Commments <small>{{ $post->comments()->count() }} total</small></h3>
			<table class="table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Comment</th>
						<th width="70px"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($post->comments as $comment)
						<tr>
							<td>{{ $comment->name }}</td>
							<td>{{ $comment->email }}</td>
							<td>{{ $comment->comment }}</td>
							<td width="70px">
								<a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary"><small class="glyphicon glyphicon-pencil"></small></a>
								<a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger"><small class="glyphicon glyphicon-trash"></small></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-4">
		<div class="well">
			<dl class="dl-horizontal"><!-- helyrerakni-->
				<dt>Url:</dt>
				<dd><p><a href="{{ url('blog',$post->slug) }}">{{ url($post->slug) }}</a></p></dd><!-- route(blog.single) a linkbe url helyett -->
				<dt>Category:</dt>
				<dd> {{ $post->category->name }}</dd>
				<dt>Created at:</dt>
				<dd>{{ date('M j Y H:j',strtotime($post->created_at)) }}</dd>
				<dt>Last updated at:</dt>
				<dd>{{ date('M j Y H:j',strtotime($post->updated_at)) }}</dd>
			</dl>
			<hr>
			<div class="row">
				<div class="col-md-6">
					{!! Html::linkRoute('posts.edit' ,'Edit', array($post->id), array('class' => 'btn btn-warning btn-block')) !!}
				</div>
				<div class="col-md-6">
					{!! Form::open(["route" => ["posts.destroy", $post->id], "method" => "DELETE"]) !!}
					{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
					{!! Form::close() !!}
					
					
				</div>				
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ Html::linkRoute('posts.index', "<< See All Posts", [], ['class' => 'btn btn-default btn-block btn-h1-spacing']) }}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection