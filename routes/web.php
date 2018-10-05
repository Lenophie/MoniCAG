<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');
Route::get('/new-borrowing', 'NewBorrowingController@index');
Route::post('/new-borrowing', 'NewBorrowingController@store');
Route::get('/end-borrowing', 'EndBorrowingController@index');
Route::patch('/end-borrowing', 'EndBorrowingController@patch');
Route::get('/borrowings-history', 'BorrowingsHistoryController@index')->name('borrowings-history');
Route::get('/view-inventory', 'ViewInventoryController@index');
Route::get('/edit-inventory', 'EditInventoryController@index');
Route::post('/edit-inventory', 'EditInventoryController@post');
Route::patch('/edit-inventory', 'EditInventoryController@patch');
Route::delete('/edit-inventory', 'EditInventoryController@delete');
Route::get('/edit-users', 'EditUsersController@index');
Route::patch('/edit-users', 'EditUsersController@patch');
Route::delete('/edit-users', 'EditUsersController@delete');
Route::get('/lang/{locale}', 'LanguagesController@change');

Auth::routes();

// TODO : Inventory modifications and movements list (needs page + table)
// TODO : Inventory items missing pieces description (needs table)