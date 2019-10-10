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

Auth::routes(['verify' => true]);

Route::redirect('/', '/dashboard');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('/auth/{provider}', 'Auth\ExternalAuthController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\ExternalAuthController@handleProviderCallback');

Route::resource('projects', 'ProjectController');
Route::resource('errors', 'ErrorController')->only(['index', 'show', 'store']);
Route::resource('users', 'UserController');

Route::get('/shared-projects', 'SharedProjectsController@index')->name('shared-projects.index');
Route::get('/shared-projects/{project}/{user}', 'SharedProjectsController@show')->name('shared-projects.show');
Route::get('/shared-projects/{project}', 'SharedProjectsController@shareTo')->name('shared-projects.share-to');
Route::put('/shared-projects/{project}/{user}', 'SharedProjectsController@share')->name('shared-projects.share');
Route::delete('/shared-projects/{project}/{user}', 'SharedProjectsController@unshare')->name('shared-projects.unshare');