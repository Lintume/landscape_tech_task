<?php

use App\Livewire\WeatherSearch;
use Illuminate\Support\Facades\Route;

Route::get('/', WeatherSearch::class);
