<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'key_value',
    ];

}
