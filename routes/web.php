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
        'tags'       => Document::select('tags')->distinct()->whereNotNull('tags')->pluck('tags'),
        'fileTypes'  => Document::select('file_type')->distinct()->whereNotNull('file_type')->pluck('file_type'),
    ]);
});

// ✅ Rute Publik Index (Pencarian) tetap di atas karena tidak menggunakan parameter dinamis {}
Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');


// ==========================================
// ---          DASHBOARD ADMIN           ---
// ==========================================

Route::get('/dashboard', function () {
    return view('dashboard', [
        'total_categories' => Category::count(),
        'total_documents'  => Document::count(),
        'latest_docs'      => Document::with('category')->latest()->take(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


// ==========================================
// ---   KELOMPOK PROTECTED (WAJIB LOGIN) ---
// ==========================================

Route::middleware('auth')->group(function () {
    
    // 1. Manajemen Profil Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Resource Kategori (Full Akses Admin)
    Route::resource('categories', CategoryController::class);

    // =============================================================
    // 3. Manajemen Dokumen Khusus Admin (Urutan Sempurna)
    // =============================================================
    
    // POSISI 1: Resource Utama Dokumen diprioritaskan di dalam auth agar /create dibaca duluan
    Route::resource('documents', DocumentController::class)->except(['index', 'show']);

    // POSISI 2: Route Custom POST tanpa ID (Hapus Massal)
    Route::post('documents/destroy-multiple', [DocumentController::class, 'destroyMultiple'])
        ->name('documents.destroy-multiple');

    // POSISI 3: Route Custom dengan ID (Download)
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])
        ->name('documents.download');
});

require __DIR__.'/auth.php';


// ==========================================
// ---      RUTE DINAMIS / PARAMETER      ---
// ==========================================

// ✅ Pindahkan rute publik 'show' ke paling bawah setelah semua rute admin selesai diperiksa.
// Ini mencegah kata 'create' atau 'destroy-multiple' tidak sengaja termakan oleh parameter {document}
Route::get('documents/{document}', [DocumentController::class, 'show'])->name('documents.show');