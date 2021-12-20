<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index')->name('index');

/* Slides */
Route::get('slides/edit','SlidesController@edit')->name('slides.edit')
      ->middleware('type:admin');
Route::put('slides/update','SlidesController@update')->name('slides.update')
      ->middleware('type:admin');
/* Slides */

/* Post Categories */
Route::resource('postCategories','PostCategoriesController');
/* Post Categories */

/* Posts */
Route::resource('posts','PostsController')->except(['index','show','edit']);
Route::get('allposts/{slug?}','PostsController@index')->name('posts.index');
Route::get('posts/{id}-{slug}','PostsController@show')->name('posts.show');
Route::get('posts/{id}-{slug}/edit','PostsController@edit')->name('posts.edit');
/* Posts */

/* Users */
Route::resource('users','UsersController')->except(['store','update']);
Route::put('users/update','UsersController@update')->name('users.update');

Route::get('login','UsersController@login')->middleware(['guest','flash_previous_url'])->name('login');
Route::post('login','UsersController@loginCheck')->middleware(['guest','flash_previous_url'])->name('login.check');
Route::post('logout','UsersController@logout')->name('logout');

Route::get('signup','UsersController@signup')->middleware(['guest','flash_previous_url'])->name('signup');
Route::post('users','UsersController@store')->middleware(['guest','flash_previous_url'])->name('users.store');

Route::get('profile','UsersController@profilePage')->middleware('auth')->name('profile');
Route::get('profiles/doctors/search','UsersController@doctorsSearch')->name('profiles.doctors.search');
/* Users */

/* Consultations */
Route::resource('consultations','ConsultationsController')->except(['show']);
Route::get('consultations/{id}-{slug}','ConsultationsController@show')->name('consultations.show');
/* Consultations */

/* Comments */
Route::resource('comments','CommentsController');
Route::put('comments/{id}/setbest','CommentsController@setBest')->name('comments.setbest');
/* Comments */

//Route::get('test',"GeneralController@test")->name('test');

Route::get('test',function(){
      return session()->all();
});

Route::get('test2',function(){
      session()->flash('hello','world');
      return session()->all();
});

Route::get('test3',function(){
      $x = session()->has('hello');
      return $x;
});