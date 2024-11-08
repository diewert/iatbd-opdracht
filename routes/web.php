<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HuisdierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OppasserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PassenAanvraagController;
use App\Http\Controllers\AdminController;



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
    return redirect('/register');
});

Route::post('/huisdieren/{huisdier}/aanmelden', [PassenAanvraagController::class, 'store'])->name('passen.store');
Route::patch('/aanvraag/{id}/behandelen', [PassenAanvraagController::class, 'update'])->name('passen.update');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/huisdieren', [HuisdierController::class, 'index'])->name('huisdieren.index');

Route::get('/aanvragen', [HuisdierController::class, 'aanvragen'])->name('huisdieren.aanvragen');

Route::get('/oppassers', [OppasserController::class, 'index'])->name('oppassers.index');
Route::get('/oppassers/{oppasser}', [OppasserController::class, 'show'])->name('oppassers.show');
Route::get('/oppasser-aanmelden', [OppasserController::class, 'create'])->name('oppasser.create');
Route::post('/oppasser-aanmelden', [OppasserController::class, 'store'])->name('oppassers.store');
Route::post('/oppassers/{oppasser}/review', [OppasserController::class, 'storeReview'])->name('oppassers.storeReview');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin']) // Zorg ervoor dat je een middleware voor admin-authenticatie hebt
    ->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/admin/block/{id}', [AdminController::class, 'blockUser'])->name('admin.block');
        Route::post('/admin/unblock/{id}', [AdminController::class, 'unblockUser'])->name('admin.unblock');
        Route::delete('/admin/request/{id}', [AdminController::class, 'deleteRequest'])->name('admin.request.delete');
    });

Route::get('/huisdier/create', [HuisdierController::class, 'create'])->name('huisdier.create');
Route::post('/huisdier', [HuisdierController::class, 'store'])->name('huisdier.store');

require __DIR__.'/auth.php';
