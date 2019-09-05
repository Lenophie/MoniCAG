<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ExplorationController@index');
Route::apiResource('borrowings', 'BorrowingController')->except(['update', 'delete']);
Route::patch('borrowings', 'BorrowingController@return')->name('borrowings.return');
Route::apiResource('inventoryItems', 'InventoryItemController');
Route::apiResource('users', 'UserController')->except(['store', 'update']);
Route::patch('users/{user}/role', 'UserController@updateRole')->name('users.changeRole');
Route::apiResource('genres', 'GenreController')->except(['show']);
