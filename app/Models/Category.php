<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // To get the posts under a single category
    // will be used in the admin panel
    // $category->categoryPost->name
    public function categoryPost() {
        return $this->hasMany(CategoryPost::class);
    }
}
