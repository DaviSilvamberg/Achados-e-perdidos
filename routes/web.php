
<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ObjetoController;
use App\Models\Objeto;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio', [
        'totalObjetos' => Objeto::count(),
        'totalDevolvidos' => Objeto::where('status', 'devolvido')->count(),
        'totalDisponiveis' => Objeto::where('status', 'disponível')->count(),
    ]);
})->name('inicio');

Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->middleware('throttle:5,1')->name('admin.login.store');
Route::post('/admin/logout', [AdminAuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/objetos', [ObjetoController::class, 'index'])->name('objetos.index');

Route::middleware(['auth', 'can:administrar-objetos'])->group(function (): void {
    Route::get('/admin', fn () => redirect()->route('objetos.index'))->name('admin.dashboard');

    Route::resource('objetos', ObjetoController::class)->only([
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ]);
});
