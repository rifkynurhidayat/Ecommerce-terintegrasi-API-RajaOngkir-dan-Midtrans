<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'orders';

    public static function availableTahun(): Collection
    {
        return Order::select(DB::raw('DISTINCT YEAR(order_date) as year'))->pluck('year');
    }

    public function order_items()
    {
        return $this->hasMany(Order_items::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
