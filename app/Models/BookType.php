<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    use HasFactory;
    protected $fillable=[
      'id_book','id_type'
    ];
    protected $primaryKey='id';
    protected $table='book_types';
}
