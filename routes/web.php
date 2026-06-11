<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('products');

Route::get('/products', function () {
    return view('welcome');
})->name('products');

Route::get('/customers', function () {
    return view('customers');
})->name('customers');
