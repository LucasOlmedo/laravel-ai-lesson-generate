<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/lesson/create', 'pages::lesson.create')->name('lesson.create');
