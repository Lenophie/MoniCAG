<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ExplorationController@index');
Route::apiResource('borrowings', 'BorrowingController')->only(['index', 'store']);
Route::patch('borrowings', 'BorrowingController@return')->name('borrowings.return');
Route::apiResource('inventoryItems', 'InventoryItemController')->except(['show']);
Route::apiResource('users', 'UserController')->only(['destroy']);
Route::patch('users/{user}/role', 'UserController@changeRole')->name('user.changeRole');
