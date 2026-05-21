<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Dokumen Akreditasi', 'color' => '#3B82F6'],
            ['name' => 'Standar KPM', 'color' => '#10B981'],
            ['name' => 'Kebijakan Peraturan', 'color' => '#F59E0B'],
            ['name' => 'Laporan', 'color' => '#6366F1'],
            ['name' => 'IKJ dan SOP', 'color' => '#EC4899'],
            ['name' => 'Formulir dan Template', 'color' => '#8B5CF6'],
            ['name' => 'Publikasi', 'color' => '#14B8A6'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'color' => $category['color'],
                'is_active' => true,
            ]);
        }
    }
}