<?php

namespace App\Models;

use App\Http\Controllers\API\Chart;
use App\Support\ProductCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'products';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // static::addGlobalScope('avgRating', function (Builder $builder) {
        //     $builder->with('avgRating');
        // });
    }

    public static function unggulan(int $limit): ProductCollection
    {
        $berapa_bulan_yang_lalu = 3; // paling banyak jumlah beli

        // Produk yang paling banyak (qty) terjual

        $builder = static::with('avgRating');
        $start = Carbon::now()->subMonth($berapa_bulan_yang_lalu);
        $end = Carbon::now();
        $builder = Product::unggulanProdukQuery($builder, 'order_items_sum_qty', null, null, $start, $end);
        return $builder->orderBy('order_items_sum_qty', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function unggulanProdukQuery(Builder $builder, string $as, $umur_rentan = null, $jenis_kelamin = null, ?Carbon $start = null, ?Carbon $end = null): Builder
    {
        $builder->withSum(["order_items as {$as}" =>
        function (Builder $builder)
        use ($umur_rentan, $jenis_kelamin, $start, $end) {
            $builder
                ->wherehas(
                    'order',
                    function (Builder $builder) use ($umur_rentan, $jenis_kelamin, $start, $end) {
                        $builder->where('status', "success");

                        if ($umur_rentan && array_key_exists('min', $umur_rentan) && array_key_exists('max', $umur_rentan)) {
                            $builder
                                ->whereRelation('user', 'umur', '>=', $umur_rentan['min'])
                                ->whereRelation('user', 'umur', '<=', $umur_rentan['max']);
                        }

                        if ($jenis_kelamin) {
                            $builder->whereRelation('user', 'jenis_kelamin', $jenis_kelamin);
                        }

                        if ($start && $end) {
                            $builder->whereBetween('order_date', [$start, $end,]);
                        }
                    }
                );
        }], 'qty');

        return $builder;
    }

    public static function seringDilihat($limit): ProductCollection
    {
        $berapa_bulan_yang_lalu = 3; // paling banyak dilihat

        return static
            ::withCount(
                ['produk_dilihat' =>
                function (Builder $builder)
                use ($berapa_bulan_yang_lalu) {
                    $builder
                        ->whereBetween('created_at', [
                            Carbon::now()
                                ->subMonth($berapa_bulan_yang_lalu),
                            Carbon::now()
                        ]);
                }]
            )
            ->orderBy('produk_dilihat_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function ratingTertinggi($limit): ProductCollection
    {
        return Product
            ::with('avgRating')
            ->withSum('testimoni', 'rating')
            ->orderBy('testimoni_sum_rating', 'desc')
            ->limit($limit)
            ->get();
    }

    public function filledStars()
    {
        return min(5, max(0, round($this->avgRating)));
    }

    public function emptyStars()
    {
        return 5 - $this->filledStars();
    }

    public function sumRating()
    {
        return $this->testimoni()
            ->selectRaw("SUM(rating) as sum_rating")
            ->groupBy('order_items.product_id');
    }

    public function avgRating()
    {
        return $this->testimoni()
            ->selectRaw("AVG(rating) as avg_rating")
            ->groupBy('order_items.product_id');
    }

    public function getAvgRatingAttribute()
    {
        if (!array_key_exists('avgRating', $this->relations)) {
            $this->load('avgRating');
        }

        $relation = $this->getRelation('avgRating')->first();

        return ($relation) ? $relation->avg_rating : null;
    }

    public function getFormatedAvgRatingAttribute()
    {
        return number_format($this->avgRating, 1, ',', '.');
    }

    public function image($index)
    {
        return explode(',', $this->img_product)[$index];
    }

    public static function penjualanProdukQuery(Builder $builder, string $as, $umur_rentan = null, $jenis_kelamin = null, ?Carbon $start = null, ?Carbon $end = null): Builder
    {
        // jumlah order sukses

        $builder->withCount(["order_items as $as" => function (Builder $builder) use ($umur_rentan, $jenis_kelamin, $start, $end) {
            $builder
                ->wherehas(
                    'order',
                    function (Builder $builder) use ($umur_rentan, $jenis_kelamin, $start, $end) {
                        $builder->where('status', "success");

                        if ($umur_rentan && array_key_exists('min', $umur_rentan) && array_key_exists('max', $umur_rentan)) {
                            $builder
                                ->whereRelation('user', 'umur', '>=', $umur_rentan['min'])
                                ->whereRelation('user', 'umur', '<=', $umur_rentan['max']);
                        }

                        if ($jenis_kelamin) {
                            $builder->whereRelation('user', 'jenis_kelamin', $jenis_kelamin);
                        }

                        if ($start && $end) {
                            $builder->whereBetween('order_date', [$start->format('Y-m-d'), $end->format('Y-m-d'),]);
                        }
                    }
                );
        }]);


        return $builder;
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function chart()
    {
        return $this->hasMany(Chart::class);
    }

    public function order_items()
    {
        return $this->hasMany(Order_items::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function produk_dilihat(): Relation
    {
        return $this->hasMany(ProdukDilihat::class);
    }

    public function testimoni(): Relation
    {
        return $this->hasManyThrough(Testimoni::class, Order_items::class, null, 'order_item_id');
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ProductCollection($models);
    }
}
