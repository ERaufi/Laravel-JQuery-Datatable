<?php

use App\Http\Controllers\CovidsController;
use App\Models\Countries;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $countries = Countries::all();
    return view('welcome', compact('countries'));
});

Route::get('get-covid-data', [CovidsController::class, 'getCovidData']);
