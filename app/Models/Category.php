<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';

    protected $fillable = ['genre'];

    public function categoryList()
    {
        return $this->hasMany(CategoryList::class, 'category_id', 'category_id');
    }

    public function memberHistory()
    {
        return $this->hasMany(MemberHistory::class, 'category_id', 'category_id');
    }

}
