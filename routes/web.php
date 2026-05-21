<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'categories' => Category::orderBy('name', 'asc')->get(),
        'years'      => Document::select('year')->distinct()->orderBy('year', 'desc')->pluck('year'),
        // Kita gunakan 'tags' karena di form input Anda namanya 'tags'
        'tags'       => Document::select('tags')->distinct()->whereNotNull('tags')->pluck('tags'),
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'total_categories' => Category::count(),
        'total_documents' => Document::count(),
        'latest_docs' => Document::with('category')->latest()->take(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('documents/{document}/download', [DocumentController::class, 'download'])
        ->name('documents.download');

    Route::resource('categories', CategoryController::class);
    Route::resource('documents', DocumentController::class);
});

require __DIR__.'/auth.php';