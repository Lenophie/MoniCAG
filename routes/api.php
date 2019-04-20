<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ExplorationController@index');
Route::apiResource('borrowings', 'BorrowingController')->only(['index', 'store']);
Route::patch('borrowings', 'BorrowingController@return')->name('borrowings.return');
