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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//Ruta de usuario
Route::get('/usuario/logeado', 'UsuarioController@logeado')->name('Usuario logeado');

//Rutas de lugares
Route::get('/poleras', 'PoleraController@index')->name('Listar poleras');
Route::post('/polera/crear/actualizar', 'PoleraController@crear_actualizar')->name('Crear o actualizar polera');
Route::post('/polera/borrar', 'PoleraController@borrar')->name('Borrar polera');

//Rutas de categorias
Route::get('/categorias/atletas', 'CategoriaController@index')->name('Listar categorias');
Route::get('/categorias/atletas/{id}', 'CategoriaController@categoria_espicifica')->name('Listar categoria');
Route::post('/categoria/crear/actualizar', 'CategoriaController@crear_actualizar')->name('Crear o actualizar categoria');
Route::post('/categoria/borrar', 'CategoriaController@borrar')->name('Borrar categoria');

//Rutas de atletas
Route::get('/atletas/categoria/{id}', 'AtletaController@index_categoria')->name('Listar atletas por categoria');
Route::post('/atletas/agregar', 'AtletaController@agregar')->name('Agregar atleta');
//Route::post('/categoria/borrar', 'AtletaController@borrar')->name('Borrar categoria');


Route::get('/{any}', 'HomeController@index')->where('any', '.*')->name('home');
