<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'code',
        'title',
        'author',
        'publisher',
        'year',
        'stock'
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}