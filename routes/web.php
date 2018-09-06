<?php

Route::get('/', function () {
    return view('home');
});

Route::get('/new-borrowing', function () {
    return view('new-borrowing');
});
