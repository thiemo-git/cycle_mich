<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trashtype extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'notes'
    ];

    public $timestamps = false;
}
