<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type_name',
        'title',
        'slug',
        'status'
    ];
    protected $primaryKey = 'id';
    protected $table = 'types';
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_types', 'id_type', 'id_book');
    }

}
