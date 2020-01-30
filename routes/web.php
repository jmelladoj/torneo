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

use App\Http\Controllers\AtletaController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//Ruta de usuario
Route::get('/usuario/logeado', 'UsuarioController@logeado')->name('Usuario logeado');
Route::get('/categorias/pagina', 'CategoriaController@index_pagina')->name('Listar categorias');

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
Route::get('/atletas/obtener', 'AtletaController@index_admin')->name('Listar atletas');
Route::get('/atletas/categoria/{id}', 'AtletaController@index_categoria')->name('Listar atletas por categoria');
Route::get('/atleta/{id}', 'AtletaController@index_admin_usuario')->name('Listar atleta');
Route::post('/atletas/admin/agregar', 'AtletaController@agregar_admin')->name('Agregar atleta');
Route::post('/atletas/admin/actualizar', 'AtletaController@actualizar_admin')->name('Agregar atleta');
Route::post('/atletas/usuario/agregar/webpay', 'AtletaController@agregar_usuario_webpay')->name('Agregar atleta webpay');
Route::post('/atletas/usuario/agregar/transferencia', 'AtletaController@agregar_usuario_transferencia')->name('Agregar atleta transferencia');
Route::post('/atleta/borrar', 'AtletaController@borrar')->name('Borrar atleta');
Route::get('/atletas/unico/{texto}', 'AtletaController@validar_unico')->name('Unico atleta');

//Rutas de categorias
Route::get('/ventas/torneo', 'VentaController@index')->name('Listar ventas');
Route::post('/venta/confirmar/pendiente', 'VentaController@confirmar_pendiente')->name('Confirmar o marcar como pendiente venta');
Route::post('/venta/anular/inscripcion', 'VentaController@eliminar_inscripcion')->name('Elimina rinscripción atleta');
Route::post('/inscripcion/procesar','VentaController@procesar')->name('Procesar inscripcion');
Route::post('/inscripcion/finalizar','VentaController@finalizar')->name('Finalizar inscripcion');

Route::get('/{any}', 'HomeController@index')->where('any', '.*')->name('home');
