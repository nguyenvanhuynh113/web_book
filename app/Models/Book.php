<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable=[
        'id','name','title','slug','sumary',
        'book_photo','id_category','id_type',
        'author','status','view','like'
    ];
    public function chapter()
    {
        return $this->hasMany(Chapter::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
    public function types()
    {
        return $this->belongsTo(Type::class);
    }
}
