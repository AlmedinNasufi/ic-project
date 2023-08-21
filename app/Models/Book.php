<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "author",
        "ISBN",
        "publication_date"
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }
}
