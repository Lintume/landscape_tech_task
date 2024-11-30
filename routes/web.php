<?php

use App\Livewire\WeatherSearch;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', WeatherSearch::class);
