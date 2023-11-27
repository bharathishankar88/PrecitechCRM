<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'oid',
        'mid',
        'pid',
        'timerange',
        'prdcount',
        'prdpercent',        
        'createdby',
        'modifiedby',
    ];
}
