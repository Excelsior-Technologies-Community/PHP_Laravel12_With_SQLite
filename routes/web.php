<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Profile Routes
Route::prefix('profiles')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profiles.index');
    Route::get('/search', [ProfileController::class, 'search'])->name('profiles.search');
    Route::get('/create', [ProfileController::class, 'create'])->name('profiles.create');
    Route::post('/store', [ProfileController::class, 'store'])->name('profiles.store');
    Route::get('/show/{id}', [ProfileController::class, 'show'])->name('profiles.show');
    Route::get('/edit/{id}', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::post('/update/{id}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::get('/delete/{id}', [ProfileController::class, 'destroy'])->name('profiles.destroy');
    Route::get('/restore/{id}', [ProfileController::class, 'restore'])->name('profiles.restore');
    Route::delete('/force-delete/{id}', [ProfileController::class, 'forceDelete'])->name('profiles.forceDelete');
    Route::post('/bulk-delete', [ProfileController::class, 'bulkDelete'])->name('profiles.bulkDelete');
    Route::get('/export', [ProfileController::class, 'export'])->name('profiles.export');
    Route::get('/trashed', [ProfileController::class, 'trashed'])->name('profiles.trashed');
});