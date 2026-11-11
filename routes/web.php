
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObjetoController;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::resource('objetos', ObjetoController::class);
