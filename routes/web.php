<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/new-borrowing', 'NewBorrowingController@index');
Route::post('/new-borrowing', 'NewBorrowingController@store');
Route::get('/end-borrowing', 'EndBorrowingController@index');
Route::post('/end-borrowing/returned', 'EndBorrowingController@updateReturned');
Route::post('/end-borrowing/lost', 'EndBorrowingController@updateLost');
Route::get('/borrowings-history', 'BorrowingsHistoryController@index')->name('borrowings-history');
Route::get('/view-inventory', 'ViewInventoryController@index');
Route::get('/edit-inventory', 'EditInventoryController@index');
Route::get('/user', 'UserController@index');

Auth::routes();