<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat User Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@lpm.ac.id',
            'password' => Hash::make('password'), 
        ]);

        // 2. Membuat Kategori Awal Lengkap (Sesuai list yang Anda berikan)
        $categories = [
            ['name' => 'Dokumen Akreditasi', 'color' => '#3B82F6'],
            ['name' => 'Standar KPM', 'color' => '#10B981'],
            ['name' => 'Kebijakan Peraturan', 'color' => '#F59E0B'],
            ['name' => 'Laporan', 'color' => '#6366F1'],
            ['name' => 'IKJ dan SOP', 'color' => '#EC4899'],
            ['name' => 'Formulir dan Template', 'color' => '#8B5CF6'],
            ['name' => 'Publikasi', 'color' => '#14B8A6'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'color' => $cat['color'] ?? '#3B82F6',
                'is_active' => true,
                'parent_id' => null, // Ini kategori utama
            ]);
        }
    }
}