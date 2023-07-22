<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','title','content','id_book','status','slug'
    ];
    protected $primaryKey='id';
    protected $table='chapters';
    public function books()
    {
        return $this->belongsTo(Book::class);
    }
}
