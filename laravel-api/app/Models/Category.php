<?php

namespace App\Models;

use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends BaseModel
{
    use HasRecursiveRelationships;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'sort_order',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
