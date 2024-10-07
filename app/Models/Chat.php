<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'chat';

        public function order()
        {
            return $this->hasOne(Order::class);
        }

}
