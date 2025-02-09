<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'member_id';

    protected $fillable = ['name', 'phone', 'email', 'address'];
}
