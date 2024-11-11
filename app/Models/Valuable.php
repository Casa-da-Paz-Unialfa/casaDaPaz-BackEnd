<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valuable extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'vacancies',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
