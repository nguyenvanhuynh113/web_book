<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_book', 'id_user'
    ];
    protected $primaryKey = 'id';
    protected $table = 'likes';
}
