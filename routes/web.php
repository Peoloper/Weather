<?php

use App\Http\Controllers\backend\CityController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware'=>['auth']], function ()
{
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/getCity', [HomeController::class, 'getCity'])->name('home.get-city');


    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/getCities', [DashboardController::class, 'getCities'])->name('dashboard.cities-get');
    Route::get('dashboard/getCity/{id}', [DashboardController::class, 'getCity'])->name('dashboard.getCity-id');

});


Route::group(['prefix' => 'admin', 'as'=>'admin.', 'middleware'=>['auth', 'admin']], function (){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/getCities', [DashboardController::class, 'getCities'])->name('dashboard.cities-get');
    Route::get('dashboard/getCity/{id}', [DashboardController::class, 'getCity'])->name('dashboard.getCity-id');

    Route::get('cities', [CityController::class, 'index'])->name('city.index');
    Route::post('city/store', [CityController::class, 'store'])->name('city.store');
    Route::delete('city/destroy/{id}', [CityController::class, 'destroy'])->name('city.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
