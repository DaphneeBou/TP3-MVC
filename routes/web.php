<?php
use App\Routes\Route;

Route::get('/', 'HomeController@index');

Route::get('/recettes', 'RecetteController@index');
Route::get('/recette/show', 'RecetteController@show');
Route::get('/recette/create', 'RecetteController@create');
Route::post('/recette/create', 'RecetteController@store');
Route::get('/recette/edit', 'RecetteController@edit');
Route::post('/recette/edit', 'RecetteController@update');
Route::post('/recette/delete', 'RecetteController@delete');
Route::post('/recette/ingredient/store', 'RecetteController@storeIngredient');
Route::post('/recette/ingredient/delete', 'RecetteController@deleteIngredient');
Route::post('/recette/etape/store', 'RecetteController@storeEtape');
Route::post('/recette/etape/delete', 'RecetteController@deleteEtape');

Route::get('/categories', 'CategorieController@index');
Route::get('/categorie/show', 'CategorieController@show');

Route::get('/user/create', 'UserController@create');
Route::post('/user/create', 'UserController@store');

Route::get('/login', 'AuthController@create');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');

Route::get('/journal', 'JournalController@index');

Route::dispatch();
