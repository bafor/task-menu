<?php

use Illuminate\Support\Facades\Route;

Route::post('/menus', 'CreateMenu@create');
Route::get('/menus/{menu}', 'ShowMenu@show');
Route::put('/menus/{menu}', 'MenuController@update');
Route::patch('/menus/{menu}', 'MenuController@update');
Route::delete('/menus/{menu}', 'DeleteMenu@destroy');

Route::post('/menus/{menu}/items', 'MenuItemController@store');
Route::get('/menus/{menu}/items', 'ShowMenuItems@showItems');
Route::delete('/menus/{menu}/items', 'MenuItemController@destroy');

Route::get('/menus/{menu}/layers/{layer}', 'MenuLayerController@show');
Route::delete('/menus/{menu}/layers/{layer}', 'MenuLayerController@destroy');

Route::get('/menus/{menu}/depth', 'MenuDepthController@show');

Route::post('/items', 'ItemController@store');
Route::get('/items/{item}', 'ItemController@show');
Route::put('/items/{item}', 'ItemController@update');
Route::patch('/items/{item}', 'ItemController@update');
Route::delete('/items/{item}', 'ItemController@destroy');

Route::post('/items/{item}/children', 'ItemChildrenController@store');
Route::get('/items/{item}/children', 'ItemChildrenController@show');
Route::delete('/items/{item}/children', 'ItemChildrenController@destroy');
