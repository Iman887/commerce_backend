<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'price',
        'pages',
        'description',
        'publication_year',
        'cover_image',
        'epub_file',
        'rating',
        'total_sold',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
