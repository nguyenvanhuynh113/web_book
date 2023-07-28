<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'title', 'slug', 'sumary',
        'book_photo',
        'author', 'status', 'view', 'like','audio'
    ];

    public function chapter()
    {
        return $this->hasMany(Chapter::class,'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories', 'id_book', 'id_category');
    }

    public function types()
    {
        return $this->belongsToMany(Type::class, 'book_types', 'id_book', 'id_type');
    }

    public function like()
    {
        return $this->belongsToMany(Like::class);
    }
}
