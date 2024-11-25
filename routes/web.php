<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/blog');
})->name('home');

Route::resource('blog', BlogController::class)
    ->only(['index', 'show']);
