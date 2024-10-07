<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='categories';
    const COLOR = [
        '#32a854',
        '#32a2a8'
    ];
    public function product()
    {
        return $this->hasMany(Product::class);
    }

    
}
