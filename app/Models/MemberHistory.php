<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberHistory extends Model
{
    protected $table = 'member_history';

    protected $primaryKey = 'borrow_id';

    protected $fillable = ['member_id', 'book_id', 'due_date', 'borrowed_at', 'returned_at'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

}
