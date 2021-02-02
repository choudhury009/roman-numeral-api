<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/number-to-numeral/{number}', 'RomanNumeralController@numberToNumeral');
Route::get('/recently-converted', 'RomanNumeralController@recentlyConverted');
Route::get('/top-ten', 'RomanNumeralController@topTenConverted');
