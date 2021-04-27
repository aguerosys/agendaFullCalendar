<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{EventController, HomeController};

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

Route::get('/', function () {
    return view('event.index');
})->middleware('auth');

Auth::routes();

Route::group(['middleware' => ['auth']], function(){



Route::get('/evento', [EventController::class, 'index']);

Route::post('/evento/mostrar', [EventController::class, 'show']);

Route::post('/evento/agregar', [EventController::class, 'store']);

Route::post('/evento/editar/{id}', [EventController::class, 'edit']);

Route::post('/evento/actualizar/{event}', [EventController::class, 'update']);

Route::post('/evento/borrar/{id}', [EventController::class, 'destroy']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

});