<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transparency extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'file',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
