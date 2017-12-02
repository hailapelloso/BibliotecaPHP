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
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/livros', ['uses'=>'BookController@index', 'as'=>'book.index']);
Route::get('/livros/add', ['uses'=>'BookController@add', 'as'=>'book.add']);
Route::post('/livros/save', ['uses'=>'BookController@save', 'as'=>'book.save']);
Route::get('/livros/edit/{id}', ['uses'=>'BookController@edit', 'as'=>'book.edit']);
Route::post('/livros/update/{id}', ['uses'=>'BookController@update', 'as'=>'book.update']);
Route::get('/livros/delete/{id}', ['uses'=>'BookController@delete', 'as'=>'book.delete']);
Route::put('/livros/search', ['uses'=>'BookController@search', 'as'=>'book.search']);

Route::get('/autores', ['uses'=>'AuthorController@index', 'as'=>'author.index']);
Route::get('/autores/add', ['uses'=>'AuthorController@add', 'as'=>'author.add']);
Route::post('/autores/save', ['uses'=>'AuthorController@save', 'as'=>'author.save']);
Route::get('/autores/edit/{id}', ['uses'=>'AuthorController@edit', 'as'=>'author.edit']);
Route::post('/autores/update/{id}', ['uses'=>'AuthorController@update', 'as'=>'author.update']);
Route::get('/autores/delete/{id}', ['uses'=>'AuthorController@delete', 'as'=>'author.delete']);
Route::put('/autores/search', ['uses'=>'AuthorController@search', 'as'=>'author.search']);

Route::get('/emprestimo', ['uses'=>'LoanController@index', 'as'=>'loan.index']);
Route::get('/emprestimo/add', ['uses'=>'LoanController@add', 'as'=>'loan.add']);
Route::get('/emprestimo/devolve/{id}', ['uses'=>'LoanController@devolve', 'as'=>'loan.devolve']);
Route::put('/emprestimo/search', ['uses'=>'LoanController@search', 'as'=>'loan.search']);
Route::post('/emprestimo/save', ['uses'=>'LoanController@save', 'as'=>'loan.save']);