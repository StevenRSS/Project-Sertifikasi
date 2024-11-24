<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    protected $primaryKey = 'book_id';

    protected $fillable = ['title', 'author'];

    public function categoryList()
    {
        return $this->hasMany(CategoryList::class, 'book_id', 'book_id');
    }

    public function memberHistory()
    {
        return $this->hasMany(MemberHistory::class, 'book_id', 'book_id');
    }

}
