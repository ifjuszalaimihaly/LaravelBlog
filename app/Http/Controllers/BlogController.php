<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

class BlogController extends Controller
{
    
	public function index(){
		$posts = Post::orderBy('updated_at','desc')->paginate(10);
		return view('blog.index')->withPosts($posts);
	}


	public function single($slug){
		$post = Post::where('slug', '=', $slug)->first();
		return view('blog.single')->withPost($post);
	}

}
