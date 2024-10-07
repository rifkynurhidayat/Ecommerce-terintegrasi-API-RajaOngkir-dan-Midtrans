<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Chart extends Controller
{
    const NAMA_BULAN_DALAM_TAHUN = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    public function preferensi(Request $request)
    {
        $year = date('Y');
        if ($request->has('year')) {
            $year = $request->query('year');
        }

        $month = 'last_3_months';
        if ($request->has('month')) {
            $month = $request->query('month');
        }

        $type = 'preferensi';
        if ($request->has('type')) {
            $type = $request->query('type');
            if (!in_array($type, ['preferensi', 'unggulan'])) {
                $type = 'preferensi';
            }
        }

        $categories = Categories::all();

        $umur_rentan = User::UMUR_RENTAN;

        $chartBuilder = Product::query();
        foreach (['L', 'P'] as $jk) {
            foreach ($umur_rentan as $key => $value) {
                if ($month == 'last_3_months') {
                    $start = Carbon::now()->setYear($year)->subMonths(3);
                    $end = Carbon::now()->setYear($year);
                } elseif ($month == 'all') {
                    $start = Carbon::create($year, 1)->startOfMonth();
                    $end = Carbon::create($year, 12)->endOfMonth();
                } else {
                    $start = Carbon::create($year, $month)->startOfMonth();
                    $end = Carbon::create($year, $month)->endOfMonth();
                }

                if ($type == 'preferensi') {
                    $chartBuilder = Product::penjualanProdukQuery($chartBuilder, "{$key}_{$jk}", $value, $jk, $start, $end);
                } else if ($type == 'unggulan') {
                    $chartBuilder = Product::unggulanProdukQuery($chartBuilder, "{$key}_{$jk}", $value, $jk, $start, $end);
                }
            }
        }

        $products = $chartBuilder->get(); // query start

        $datasets = [];
        foreach (['L', 'P'] as $jk) {
            foreach ($umur_rentan as $key => $value) {
                $backgroud_color = [];

                $red = $value['color']['r'];
                $green = $value['color']['g'];
                $blue = $value['color']['b'];
                $opac = ($jk == 'L') ? '1' : '0.5';

                $data = [];
                foreach ($categories as $categorie) {
                    $sum = 0;
                    foreach ($products as $pro)
                        if ($pro->categories_id == $categorie->id)
                            $sum += $pro->{"{$key}_{$jk}"};
                    $data[] = $sum;
                    $backgroud_color[] = "rgba($red, $green, $blue, $opac)";
                }

                $datasets[] = [
                    'label' => $value['as'] . ' ' . $jk,
                    'data' => $data,
                    'backgroundColor' => $backgroud_color
                ];
            }
        }

        return [
            'labels' => $categories->pluck('category_name'),
            'datasets' => $datasets,
        ];
    }

    public function sebaranKategori()
    {
        $categories = Categories::withCount('product')->get();

        return [
            'labels' => $categories->pluck('category_name'),
            'datasets' => [[
                'data' => $categories->pluck('product_count'),
            ]],
        ];
    }

    public function penjualan(Request $request)
    {
        $year = date('Y');
        if ($request->has('year')) {
            $year = $request->query('year');
        }

        $umur_rentan = User::UMUR_RENTAN;

        $chartBuilder = Transaction::query();
        foreach (['L', 'P'] as $jk) {
            foreach ($umur_rentan as $key => $value) {
                foreach (Chart::NAMA_BULAN_DALAM_TAHUN as $no_bulan => $na_bulan) {
                    $start = Carbon::create($year, $no_bulan)->startOfMonth();
                    $end = Carbon::create($year, $no_bulan)->endOfMonth();
                    $chartBuilder = Transaction::penjualanNominalQuery($chartBuilder, "{$key}_{$jk}_{$no_bulan}", $value, $jk, $start, $end);
                }
            }
        }

        $transactions = $chartBuilder->get(); // query start

        $datasets = [];
        foreach (['L', 'P'] as $jk) {
            foreach ($umur_rentan as $key => $value) {
                $red = $value['color']['r'];
                $green = $value['color']['g'];
                $blue = $value['color']['b'];
                $opac = ($jk == 'L') ? '1' : '0.5';

                $data = [];
                foreach (Chart::NAMA_BULAN_DALAM_TAHUN as $no_bulan => $na_bulan) {
                    $sum = 0;
                    foreach ($transactions as $transaction) {
                        $sum += $transaction->{"{$key}_{$jk}_{$no_bulan}"};
                    }
                    $data[] = $sum;
                }

                $datasets[] = [
                    'label' => $value['as'] . ' ' . $jk,
                    'data' => $data,
                    'borderColor' => "rgba($red, $green, $blue, $opac)"
                ];
            }
        }

        return [
            'labels' => array_values(Chart::NAMA_BULAN_DALAM_TAHUN),
            'datasets' => $datasets,
        ];
    }

    public function sebaranDemografi()
    {
        $umur_rentan = User::UMUR_RENTAN;

        $builder = DB::query();
        $labels = [];
        $bg_colors = [];
        foreach (['L', 'P'] as $jk) {
            foreach ($umur_rentan as $key => $value) {
                $red = $value['color']['r'];
                $green = $value['color']['g'];
                $blue = $value['color']['b'];
                $opac = ($jk == 'L') ? '1' : '0.5';

                $labels[] = $value['as'] . ' ' . $jk;
                $bg_colors[] = "rgba($red, $green, $blue, $opac)";

                $sub = User::select('id')
                    ->where('umur', '>=', $value['min'])
                    ->where('umur', '<=', $value['max']);

                $sub->where('jenis_kelamin', $jk);

                $sql = $sub->toSql();

                $builder->selectRaw("(SELECT COUNT(*) FROM ($sql) AS `any`) AS `{$key}_{$jk}`", $sub->getBindings());
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [[
                'data' => array_values(collect($builder->first())->toArray()),
                'backgroundColor' => $bg_colors
            ]],
        ];
    }
}
