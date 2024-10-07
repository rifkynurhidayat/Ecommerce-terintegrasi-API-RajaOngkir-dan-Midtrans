<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'transactions';

    public static function penjualanNominalQuery(Builder $builder, string $as, $umur_rentan = null, $jenis_kelamin = null, ?Carbon $start = null, ?Carbon $end = null): Builder
    {
        $sub = Transaction::select('id')
            ->whereHas(
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
                        $builder->where(function($q) use ($start, $end){
                            $q->where('order_date', '>=', $start->format('Y-m-d'));
                            $q->where('order_date', '<=', $end->format('Y-m-d'));
                        });
                        // $builder->whereBetween('order_date', [$start, $end,]);
                    }
                }
            );
        $sql = $sub->toSql();
        // dd("SUM(CASE WHEN (id IN ($sql)) THEN total_payment ELSE 0 END) as {$as}", $sub->getBindings());
        return $builder->selectRaw("SUM(CASE WHEN (id IN ($sql)) THEN total_payment ELSE 0 END) as {$as}", $sub->getBindings());
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
