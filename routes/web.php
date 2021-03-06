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

//Route::get('/',['as' => 'exit', 'uses' => 'LoginController@loginPage']);
Route::get('/', 'LoginController@loginPage');
Route::post('/login', 'LoginController@adminLogin');
Route::get('/logout', 'LoginController@logout');

//Route::get('/complaints', 'ComplaintController@complaints');
/*
//passing optional parameter
Route::get('/complaints/{status?}', function ($status = 'all') {
    $controller = new \App\Http\Controllers\ComplaintController();
    return $controller->complaints($status);
});
*/
Route::get('/complaints/{status?}', 'ComplaintController@complaints'); //passing optional parameter
Route::post('/complaint/create', 'ComplaintController@createComplaint');

Route::get('/complaint/{id}/edit', 'ComplaintController@editComplaint');
Route::post('/complaint/change_status', 'ComplaintController@changeStatus');
Route::post('/complaint/show_time_line', 'ComplaintController@showTimeLine');
Route::post('/complaint/{id}/update_complaint', 'ComplaintController@updateComplaint');
Route::get('/complaint/{id}/delete', 'ComplaintController@deleteComplaint');
