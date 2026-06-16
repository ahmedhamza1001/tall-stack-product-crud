<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.landing');
})->name('landing');

Route::get('/products', function () {
    return view('welcome');
})->name('products');

Route::get('/customers', function () {
    return view('customers');
})->name('customers');
