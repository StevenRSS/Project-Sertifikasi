<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryList extends Model
{
    protected $table = 'category_list';

    protected $fillable = ['book_id', 'category_id', 'genre']; 

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
