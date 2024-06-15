<?php

namespace App\Actions\Category;

use App\Models\Category;

class GetAllCategoriesAction
{
    public static function run()
    {
        return Category::hasChildren()
                    ->with(['children' => fn ($q) => $q->orderBy('sort_order')])
                    ->orderBy('name')
                    ->get();
    }
}
