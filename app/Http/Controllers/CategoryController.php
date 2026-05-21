<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Menghitung jumlah dokumen per kategori
        // Menambahkan relasi 'children' agar sub-kategori muncul di bawah induknya
        $query = Category::with(['children'])->withCount('documents');

        // Logika Pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil nilai per_page dari request, default 10
        $perPage = $request->get('per_page', 10);

        /**
         * Mengambil kategori induk saja (parent_id NULL)
         * Gunakan withQueryString() agar filter 'search' dan 'per_page' 
         * tidak hilang saat user mengklik nomor halaman di pagination.
         */
        $categories = $query->whereNull('parent_id') 
                            ->latest()
                            ->paginate($perPage)
                            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'color' => 'required|string|max:7',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
            'color.required' => 'Warna label wajib dipilih.',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'color' => $request->color,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit kategori
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
                                    ->where('id', '!=', $category->id)
                                    ->get();

        return view('categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Memperbarui data kategori
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'color' => 'required|string|max:7',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'color.required' => 'Warna label wajib dipilih.',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'color' => $request->color,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}