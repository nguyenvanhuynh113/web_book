<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'category_name', 'title', 'slug', 'status'
    ];
    protected $primaryKey = 'id';
    protected $table = 'categories';

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_categories', 'id_category', 'id_book');
    }

}
