<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionCasa extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
        'position',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
