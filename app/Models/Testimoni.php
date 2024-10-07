<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $guarded = [];
    protected $table = 'testimonials';
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_item()
    {
        return $this->belongsTo(Order_items::class, 'order_item_id');
    }
}
