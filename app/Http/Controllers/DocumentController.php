<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Menampilkan daftar dokumen dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = Document::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $documents = $query->latest()->paginate(10);
        $categories = Category::whereNull('parent_id')->get();
        
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
     * --- BARU: Menampilkan Detail Dokumen (Lihat) ---
     */
    public function show(Document $document)
    {
        // Memuat relasi kategori agar bisa ditampilkan di detail
        $document->load('category');
        return view('documents.show', compact('document'));
    }

    /**
     * --- BARU: Menampilkan Form Edit ---
     */
    public function edit(Document $document)
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('documents.edit', compact('document', 'categories'));
    }

    /**
     * --- BARU: Memproses Update Dokumen ---
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

        // Jika ada file baru yang diunggah
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Simpan file baru
            $file = $request->file('file');
            $data['file_type'] = strtoupper($file->getClientOriginalExtension());
            $data['file_path'] = $file->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Fitur Download
     */
    public function download(Document $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);
            $fileName = $document->title . '.' . $extension;

            return Storage::disk('public')->download($document->file_path, $fileName);
        }
        
        return back()->with('error', 'File fisik tidak ditemukan di server.');
    }

    /**
     * Menghapus Dokumen
     */
    public function destroy(Document $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}