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



Route::get('/', 'Article\IndexController')->name('articles.index');
Route::get('articles/{id}', 'Article\ShowController')->name('articles.show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('articles/create', 'Article\CreateController')->name('articles.create');
    Route::post('articles', 'Article\StoreController')->name('articles.store');
    Route::get('articles/{id}/edit', 'Article\EditController')->name('articles.edit');
    Route::patch('articles/{id}', 'Article\UpdateController')->name('articles.update');
    Route::delete('articles/{id}', 'Article\DestroyController')->name('articles.destroy');
});

Auth::routes();

