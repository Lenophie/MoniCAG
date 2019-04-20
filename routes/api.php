<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ExplorationController@index');
Route::apiResources([
    'borrowings' => 'BorrowingController',
]);
