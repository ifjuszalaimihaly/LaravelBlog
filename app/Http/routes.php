<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/','PagesController@index');


Route::get('about','PagesController@about');


Route::get('contact','PagesController@contact');

Route::resource('posts','PostController');
*/




//Route::group(['middleware' => ['web']], function () {

	Route::get('auth/login',['as' => 'login','uses' => 'Auth\AuthController@getLogin']);
	Route::post('auth/login','Auth\AuthController@postLogin');
	Route::get('auth/logout',['as' => 'logout','uses' => 'Auth\AuthController@getLogout']);

	Route::get('auth/register','Auth\AuthController@getRegister');
	Route::post('auth/register','Auth\AuthController@postRegister');

	Route::get('password/reset/{token?}','Auth\PasswordController@showResetForm');
	Route::post('password/email','Auth\PasswordController@sendResetLinkEmail');
	Route::post('password/reset','Auth\PasswordController@reset');


	Route::get('blog/{slug}',  ['as' => 'blog.single', 'uses' => 'BlogController@single'])->where('slug', '[\w\d\-\_@]+');
	Route::get('blog',['as' => 'blog.index', 'uses' => 'BlogController@index']);

	Route::get('/','PagesController@index');
	Route::get('about','PagesController@about');
	Route::get('contact','PagesController@contact');
	Route::post('contact','PagesController@postcontact');

	Route::resource('posts','PostController');
	Route::resource('categories','CategoryController',['except' =>['create']]); //only opposite
	Route::resource('tags','TagController',['except' =>['create']]); 

	//comments
	Route::post('comments/{post_id}',['uses' => 'CommentsController@store', 'as' => 'comments.store']);
	Route::get('comments/{id}/edit', ['uses' => 'CommentsController@edit', 'as' => 'comments.edit']);
	Route::put('comments/{id}', ['uses' => 'CommentsController@update', 'as' => 'comments.update']);
	Route::delete('comments/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy']);
	Route::get('comments/{id}/delete', ['uses' => 'CommentsController@delete', 'as' => 'comments.delete']);

//});

