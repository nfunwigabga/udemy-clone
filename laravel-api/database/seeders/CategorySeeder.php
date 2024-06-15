<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();

        $categories = File::json('database/data/categories.json');

        foreach ($categories as $index => $category) {
            $parent = Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'sort_order' => $index,
            ]);

            foreach ($category['children'] as $childIndex => $child) {
                Category::create([
                    'name' => $child['name'],
                    'slug' => Str::slug($child['name']),
                    'parent_id' => $parent->id,
                    'sort_order' => $childIndex,
                ]);
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
