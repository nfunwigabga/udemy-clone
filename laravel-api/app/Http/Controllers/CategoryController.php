<?php

namespace App\Http\Controllers;

use App\Actions\Category\GetAllCategoriesAction;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = GetAllCategoriesAction::run();

        return CategoryResource::collection($categories);
    }
}
