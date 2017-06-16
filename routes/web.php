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
use Illuminate\Routing\Router;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'contacts'], function(Router $router){
    $router->get('/', [
        'as' => 'contacts',
        'uses' => 'ContactsController@index'
    ]);

    $router->get('/{id}', [
        'as' => 'contacts.show',
        'uses' => 'ContactsController@show'
    ]);

    $router->post('/create', [
        'as' => 'contacts.create',
        'uses' => 'ContactsController@create'
    ]);

    $router->post('/{id}', [
        'as' => 'contacts.update',
        'uses' => 'ContactsController@update'
    ]);

    $router->get('/delete/{id}', [
        'as' => 'contacts.delete',
        'uses' => 'ContactsController@delete'
    ]);

});

