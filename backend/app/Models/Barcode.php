<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'notes'
    ];

    public function trashtypes()
    {
        return $this->belongsToMany(Trashtype::class);
    }
}
