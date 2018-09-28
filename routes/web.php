<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');
Route::get('/new-borrowing', 'NewBorrowingController@index');
Route::post('/new-borrowing', 'NewBorrowingController@store');
Route::get('/end-borrowing', 'EndBorrowingController@index');
Route::post('/end-borrowing/returned', 'EndBorrowingController@updateReturned');
Route::post('/end-borrowing/lost', 'EndBorrowingController@updateLost');
Route::get('/borrowings-history', 'BorrowingsHistoryController@index')->name('borrowings-history');
Route::get('/view-inventory', 'ViewInventoryController@index');
Route::get('/edit-inventory', 'EditInventoryController@index');
Route::post('/edit-inventory', 'EditInventoryController@post');
Route::patch('/edit-inventory', 'EditInventoryController@patch');
Route::delete('/edit-inventory', 'EditInventoryController@delete');
Route::get('/user', 'UserController@index');
Route::get('/lang/{locale}', 'LanguagesController@change');

Auth::routes();

// TO DO : Inventory modifications and movements list (needs page + table)