<?php

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

use App\Mail\NewUserWelcomeMail;

Auth::routes();

///////////////////gb codes
Route::get('/', 'WelcomeController@index' );
Route::get('/apply', 'ApplyController@index' );
Route::post('/prog/{fac}', 'ApplyController@show');
Route::post('/progamt/{prog_id}', 'ApplyController@show2');
Route::post('/form_rrr/{form_id}/{rrr}', 'ApplyController@show3');
Route::post('/form_view/{form_id}', 'ApplyController@show4');
Route::get('/apply/view', 'ApplyController@viewmyform');
Route::get('/apply/form', 'ApplyController@viewform');
Route::post('/apply/submit', 'ApplyController@store');
Route::post('/saveform', 'ApplyController@saveform');
Route::post('/uplimg', 'ApplyController@uplimage');
Route::post('/subform', 'ApplyController@subform');

//////////////////////////////saveform

Route::get('/email', function () {
    return new NewUserWelcomeMail();
});

Route::post('follow/{user}', 'FollowsController@store');

//Route::get('/', 'PostsController@index');
Route::get('/p/create', 'PostsController@create');
Route::post('/p', 'PostsController@store');
Route::get('/p/{post}', 'PostsController@show');

Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');
