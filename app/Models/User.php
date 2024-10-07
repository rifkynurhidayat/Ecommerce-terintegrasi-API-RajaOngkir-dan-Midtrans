<?php

namespace App\Models;

use App\Support\ProductCollection;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const UMUR_RENTAN = [
        'remaja' => [
            'min' => 12, 'max' => 19, 'as' => 'R (12-19)',
            'color' => [
                'r' => 153,
                'g' => 102,
                'b' => 255
            ]
        ],
        'dewasa' => [
            'min' => 20, 'max' => 40, 'as' => 'D (20-40)',
            'color' => [
                'r' => 255,
                'g' => 99,
                'b' => 132
            ]
        ],
        'orang_tua' => [
            'min' => 41, 'max' => 100, 'as' => 'OT (41-100)',
            'color' => [
                'r' => 75,
                'g' => 192,
                'b' => 192
            ]
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    protected $table = 'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getKategoriUmur()
    {
        foreach (User::UMUR_RENTAN as $key => $value) {
            if ($this->umur >= $value['min'] && $this->umur <= $value['max']) {
                return $key;
            }
        }
    }

    public function getKategoriUmurRentan()
    {
        return User::UMUR_RENTAN[$this->getKategoriUmur()];
    }

    public function preferensi($limit): ProductCollection
    {
        $umur_rentan = $this->getKategoriUmurRentan();
        $berapa_bulan_yang_lalu = 3; // paling banyak transaksi;

        // Produk yang sering di order oleh demografi user

        $start = Carbon::now()->subMonths($berapa_bulan_yang_lalu);
        $end = Carbon::now();

        $builder = Product::with('avgRating');

        $builder = Product::penjualanProdukQuery(
            $builder,
            'order_items_count',
            $umur_rentan,
            $this->jenis_kelamin,
            $start,
            $end
        );

        return $builder
            ->orderBy('order_items_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function order_items()
    {
        return $this->hasMany(Order_items::class);
    }

    public function transaction()
    {
        return $this->hasManyThrough(Transaction::class, Order::class);
    }

    public function produkDilihat(): Relation
    {
        return $this->hasMany(ProdukDilihat::class);
    }

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }
}
