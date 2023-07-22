<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooKCategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'id_book','id_category'
    ];
    protected $primaryKey='id';
    protected $table='book_categories';
}
