<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Menampilkan daftar dokumen dengan fitur pencarian dan filter.
     * Mendukung tampilan admin di dashboard dan tampilan publik dari beranda.
     */
    public function index(Request $request)
    {
        $query = Document::with('category');

        // ==========================================
        // LOGIKA PRIVASI: PERBEDAAN ADMIN DAN PUBLIK
        // ==========================================
        if (!Auth::check()) {
            // Jika pengunjung adalah PUBLIK (Belum Login):
            // Hanya izinkan dokumen yang berstatus 'Published'
            $query->where('status', 'Published');
        }

        // Filter Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        // Filter Kategori (induk atau sub)
        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;
            $query->where(function($q) use ($categoryId) {
                $q->where('category_id', $categoryId)
                  ->orWhereHas('category', function($sub) use ($categoryId) {
                      $sub->where('parent_id', $categoryId);
                  });
            });
        }

        // Filter Sub Kategori
        if ($request->filled('sub_category_id')) {
            $query->where('category_id', $request->sub_category_id);
        }

        // Filter Tipe Dokumen
        if ($request->filled('file_type')) {
            $query->where('file_type', $request->file_type);
        }

        // Filter Tahun
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Filter Tags
        if ($request->filled('tag')) {
            $query->where('tags', 'like', '%' . $request->tag . '%');
        }

        // Ambil data hasil filter dengan pagination (bawa query string agar filter tidak hilang saat pindah halaman)
        $documents = $query->latest()->paginate(10)->withQueryString();
        
        // Mengambil kategori utama BESERTA anak-anaknya (sub-kategori) untuk dropdown filter publik
        $categories = Category::whereNull('parent_id')->with('children')->get();

        // ==========================================
        // PENYIAPAN DATA UNTUK WELCOME VIEW (PUBLIK)
        // ==========================================
        // Menyiapkan variabel filter agar welcome.blade.php tidak error saat rendering
        $fileTypes = Document::when(!Auth::check(), function($q) {
                        $q->where('status', 'Published');
                     })
                     ->whereNotNull('file_type')
                     ->distinct()
                     ->pluck('file_type');

        $years = Document::when(!Auth::check(), function($q) {
                    $q->where('status', 'Published');
                 })
                 ->whereNotNull('year')
                 ->distinct()
                 ->orderBy('year', 'desc')
                 ->pluck('year');

        // Memecah string tags menjadi array unik untuk pilihan filter
        $allTags = Document::when(!Auth::check(), function($q) {
                        $q->where('status', 'Published');
                    })
                    ->whereNotNull('tags')
                    ->pluck('tags');

        $tags = [];
        foreach ($allTags as $tagString) {
            $exploded = array_map('trim', explode(',', $tagString));
            foreach ($exploded as $t) {
                if ($t !== '' && !in_array($t, $tags)) {
                    $tags[] = $t;
                }
            }
        }

        // Jika user BELUM login, arahkan hasil pencarian ke halaman welcome dengan membawa data terfilter
        if (!Auth::check()) {
            return view('welcome', compact('documents', 'categories', 'fileTypes', 'years', 'tags'));
        }
        
        // Jika user SUDAH login (Admin), tetap arahkan ke halaman management dashboard asli Anda
        return view('documents.index', compact('documents', 'categories'));
    }

    /**
     * Tampilkan Halaman Form Upload
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('documents.create', compact('categories'));
    }

    /**
     * Menyimpan dokumen baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|digits:4',
            'file' => 'required|mimes:pdf,docx,doc,xls,xlsx,jpg,png|max:10240',
            'tags' => 'nullable|string', 
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = strtoupper($file->getClientOriginalExtension());
            $path = $file->store('documents', 'public');

            Document::create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'year' => $request->year,
                'file_type' => $extension,
                'tags' => $request->tags, 
                'status' => $request->has('publish') ? 'Published' : 'Draft',
                'file_path' => $path,
                'description' => $request->description,
            ]);

            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diarsipkan.');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }

    /**
     * Menampilkan Detail Dokumen
     */
    public function show(Document $document)
    {
        // Pengamanan tambahan: Jika publik mencoba mengakses dokumen berstatus Draft langsung via URL
        if (!Auth::check() && $document->status !== 'Published') {
            abort(403, 'Dokumen ini belum diterbitkan publik.');
        }

        $document->load('category');
        return view('documents.show', compact('document'));
    }

    /**
     * Menampilkan Form Edit
     */
    public function edit(Document $document)
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('documents.edit', compact('document', 'categories'));
    }

    /**
     * Memproses Update Dokumen
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|digits:4',
            'file' => 'nullable|mimes:pdf,docx,doc,xls,xlsx,jpg,png|max:10240',
            'tags' => 'nullable|string', 
            'description' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'year' => $request->year,
            'tags' => $request->tags,
            'description' => $request->description,
            'status' => $request->has('publish') ? 'Published' : 'Draft',
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada sebelum diganti yang baru
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $data['file_type'] = strtoupper($file->getClientOriginalExtension());
            $data['file_path'] = $file->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Fitur Download Dokumen
     */
    public function download(Document $document)
    {
        // Pengamanan tambahan: Jika publik mencoba download dokumen berstatus Draft langsung via URL
        if (!Auth::check() && $document->status !== 'Published') {
            abort(403, 'Dokumen ini belum diterbitkan publik.');
        }

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);
            $fileName = $document->title . '.' . $extension;

            return Storage::disk('public')->download($document->file_path, $fileName);
        }
        
        return back()->with('error', 'File fisik tidak ditemukan di server.');
    }

    /**
     * MENGEKSEKUSI HAPUS MASSAL (MULTIPLE)
     */
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return redirect()->route('documents.index')->with('error', 'Pilih dokumen yang akan dihapus.');
        }

        try {
            $count = 0;
            foreach ($ids as $id) {
                $document = Document::find($id);
                if ($document) {
                    // Hapus file fisik dari storage jika ada
                    if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                        Storage::disk('public')->delete($document->file_path);
                    }
                    $document->delete();
                    $count++;
                }
            }

            return redirect()->route('documents.index')->with('success', "$count dokumen berhasil dihapus massal.");
        } catch (\Exception $e) {
            return redirect()->route('documents.index')->with('error', 'Gagal hapus massal: ' . $e->getMessage());
        }
    }

    /**
     * MENGEKSEKUSI HAPUS SATUAN
     */
    public function destroy(Document $document)
    {
        try {
            // Hapus file fisik dari storage jika ada
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->delete();

            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('documents.index')->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }
}