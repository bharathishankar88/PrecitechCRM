<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rmins extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'supplierid',
        'gradeid',
        'sizemm',
        'quantity',
        'created_at',
        'modified_at',
        'created_by',
        'modified_by',
    ];
}
