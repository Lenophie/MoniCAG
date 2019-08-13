<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ExplorationController@index');
Route::apiResource('borrowings', 'BorrowingController')->only(['index', 'store']);
Route::patch('borrowings', 'BorrowingController@return')->name('borrowings.return');
Route::apiResource('inventoryItems', 'InventoryItemController');
Route::apiResource('users', 'UserController')->except(['create', 'update']);
Route::patch('users/{user}/role', 'UserController@updateRole')->name('user.changeRole');
Route::apiResource('genres', 'GenreController')->except(['show']);
