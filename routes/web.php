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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', ['uses' => 'HarmonogramPosilkowController@index', 'as' => 'index']);//->middleware('role:admin');

Route::get('/dodaj-harmonogram', ['uses' => 'HarmonogramPosilkowController@dodaj', 'as' => 'dodaj']);

Route::post('/dodaj-harmonogram', ['uses' => 'HarmonogramPosilkowController@dodajPost', 'as' => 'dodaj']);

Route::post('/usun-harmonogram/{id}', ['uses' => 'HarmonogramPosilkowController@usun', 'as' => 'usun']);

Route::get('/szczegoly-harmonogramu/{id}/{userId}', ['uses' => 'HarmonogramPosilkowController@szczegoly', 'as' => 'szczegoly']);

Route::get('/lista-harmonogramow/{id}', ['uses' => 'HarmonogramPosilkowController@listaHarmonogramow', 'as' => 'listaHarmonogramow']);

Route::post('/dodaj-posilek', ['uses' => 'HarmonogramPosilkowController@dodajPosilekPost', 'as' => 'dodajPosilek']);

Route::post('/dodaj-uwagi/{id}/{trescUwagi}/{dzien}', ['uses' => 'HarmonogramPosilkowController@dodajUwagiPost', 'as' => 'dodajUwagi']);

Route::get('/przepisy', ['uses' => 'PrzepisyController@przepisy', 'as' => 'przepisy']);
