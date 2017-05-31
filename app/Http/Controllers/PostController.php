<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use  Illuminate\Support\Facades\Input as Input;


use App\Post;
use App\Category;
use App\Tag;

use Session;

use Purifier;

use Image;

use Storage;

use File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth');
    }


    public function index()
    {
        //$posts = Post::all();
        $posts = Post::orderBy('updated_at','desc')->paginate(10);
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create')->withCategories($categories)->withTags($tags);    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request);
        $this->validate($request, array(
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required|numeric'
            ));

        $post = new Post;
        $post->title = $request->title;
        $post->body = Purifier::clean($request->body);
        $post->category_id = $request->category_id;
        $post->slug=$this->createslug($post->title);
       
        /*if($request->hasFile('featured_image')) {
           $image = $request->file('featured_image');
           $file_name= time() . '.' . $image->getClientOriginalExtension();
           
           $location = public_path('images/'.$file_name); //storage_path; asset()
           Image::make($image)->resize(800,400)->save($location);
           $post->image = $file_name;
        }*/


        $post->save();

        if(isset($request->tags)){
        $post->tags()->sync($request->tags, false); //nem írja a felül a meglévő kapcsolatokat, hanem hozzáadja
    } else {
        $post->tags()->sync(array());
    }
        //Session::flash('success','The blogpost was succesfully save!');



    //return redirect()->route('posts.show',$post->id);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $post = Post::find($id);
      return view('posts.show')->withPost($post);
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        /*$cats = [];
        foreach ($categories as $category) {
            $cats[$category_id] = $category->name;
        }*/
        $tags = Tag::all();
        return view('posts.edit')->withPost($post)->withCategories($categories)->withTags($tags);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, array(
        'title' => 'required|max:255',
        'category_id' => 'required|integer', 
        'body' => 'required',
         'featured_image' => 'somtimes|image'
        ));
      $post = Post::find($id);
      $post->title=$request->input('title');
      $post->body= Purifier::clean($request->input('body'));
      $post->slug=$this->createslug($post->title);
      $post->category_id=$request->category_id;
      /*
      if($request->hasFile('featured_image')){
         $image = $request->file('featured_image');
         $file_name= time() . '.' . $image->getClientOriginalExtension();
         $location = public_path('images/'.$file_name); //storage_path; asset();
         Image::make($image)->resize(800,400)->save($location);
         $oldfilename = $post->image;
         $post->image = $file_name;
         Stroage::delete($oldfilename);
      }
    */
      $post->save();
      $post->tags()->sync($request->tags, true);//itt felül kell írni
  


      //Session::flash('success','The blogpost was succesfully save!');

    return redirect()->route('posts.show', $post->id);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $post->tags()->detach(); // lekapcsolja róla a tageket

        $post->delete();
        //Session::flash('success','The blogpost was succesfully deleted!');

        return redirect()->route("posts.index");
    }


    //javítani
    public function createslug($s)
    {
       $hu=array('/é/','/É/','/á/','/Á/','/ó/','/Ó/','/ö/','/Ö/','/ő/','/Ő/','/ú/','/Ú/','/ű/','/Ű/','/ü/','/Ü/','/í/','/Í/','/ /');
       $en= array('e','E','a','A','o','O','o','O','o','O','u','U','u','U','u','U','i','I','-');
       $r=preg_replace($hu,$en,$s);
       $r=strtolower($r);
       return $r;
   }


}

