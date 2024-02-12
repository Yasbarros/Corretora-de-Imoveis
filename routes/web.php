<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ManagePropertyController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/search', function () {
    return Inertia::render('Search');
})->name('search');

Route::get('/search', function () {
    return Inertia::render('Search');
})->name('search');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/property', [PropertyController::class, 'index'])->name('property.index');

Route::get('/manage', function () {     
    return Inertia::render('Dashboard'); 
})->name('manage');

Route::post('/contact', ContactController::class)->name('contact');

Route::get('/manage/properties/register', [ManagePropertyController::class, 'register'] )->name('manageProperty.register');
Route::post('/manage/properties', [ManagePropertyController::class, 'store'])->name('manageProperty.store');
Route::get('/manage/properties', [ManagePropertyController::class, 'indexAdmin'])->name('manageProperty.index');
Route::get('/manage/properties/{property}', [ManagePropertyController::class, 'showAdmin'])->name('manageProperty.show');
Route::delete('/manage/properties/{property}', [ManagePropertyController::class, 'destroy'])->name('manageProperty.destroy');
Route::get('/manage/properties/{property}/edit', [ManagePropertyController::class, 'edit'])->name('manageProperty.edit');
Route::put('/manage/properties/{property}', [ManagePropertyController::class, 'update'])->name('manageProperty.update');
Route::get('/search', [ManagePropertyController::class, 'search'])->name('search');

Route::get('/', [ManagePropertyController::class, 'index'])->name('manageProperty.index');
Route::get('/properties/{property}', [ManagePropertyController::class, 'show'])->name('manageProperty.show');

Route::get('/manage/admins/register', function () {     
    return Inertia::render('RegisterAdmin'); 
})->name('registerAdmin');


Route::get('/manage/admin', function () {     
    return Inertia::render('Admin'); 
})->name('Admin');

Route::get('/manage/admins', function () {     
    return Inertia::render('Admins'); 
})->name('admins');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';