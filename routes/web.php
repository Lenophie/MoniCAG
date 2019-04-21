<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::namespace('Web')->group(function() {
    Route::get('/', 'HomeController@index');
    Route::get('/new-borrowing', 'NewBorrowingController@index');
    Route::get('/end-borrowing', 'EndBorrowingController@index');
    Route::get('/borrowings-history', 'BorrowingsHistoryController@index')->name('borrowings-history');
    Route::get('/view-inventory', 'ViewInventoryController@index');
    Route::get('/edit-inventory', 'EditInventoryController@index');
    Route::get('/edit-users', 'EditUsersController@index');
    Route::get('/lang/{locale}', 'LanguagesController@change');
    Route::get('/theme/{name}', 'ThemesController@change');
    Route::get('/account', 'AccountController@index')->name('account');
    Route::delete('/account', 'AccountController@delete')->name('account.delete');
});

Auth::routes();
Route::namespace('Auth')->group(function() {
    Route::get('/password/change', 'ChangePasswordController@index');
    Route::post('/password/change', 'ChangePasswordController@post')->name('password.change');
    Route::get('/email/change', 'ChangeEmailController@index');
    Route::post('/email/change', 'ChangeEmailController@post')->name('email.change');
});
