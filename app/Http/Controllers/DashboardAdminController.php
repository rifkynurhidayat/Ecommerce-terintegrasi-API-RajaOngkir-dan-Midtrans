<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Chat;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\Product;
use App\Models\Testimoni;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


class DashboardAdminController extends Controller
{

    public function home(Request $request)
    {
        // Ambil input tanggal mulai dan akhir dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ambil data pesanan dengan relasi transaksi, user, order_items, produk, dan kategori
        $pembelian = Order::with(['transaction.user', 'order_items.product.categories'])
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                // Jika filter tanggal diisi, ambil data dalam rentang tanggal tersebut
                if ($startDate && $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                }
            })->get();

        // Inisialisasi array untuk menyimpan data hasil
        $data = [];
        foreach ($pembelian as $order) {
            $user = $order->transaction->user;
            $age = $user->umur;
            $gender = $user->jenis_kelamin;

            // Kategorisasi umur
            if ($age >= 12 && $age <= 19) {
                $ageGroup = 'R(12-19)';
            } elseif ($age >= 20 && $age <= 40) {
                $ageGroup = 'D(20-40)';
            } else {
                $ageGroup = 'OT(41-100)';
            }

            // Tentukan label untuk kombinasi umur dan jenis kelamin
            $key = $ageGroup . ' ' . $gender;

            foreach ($order->order_items as $item) {
                $category = $item->product->categories->category_name;
                if (!isset($data[$key][$category])) {
                    $data[$key][$category] = 0;
                }
                // Tambahkan quantity dari setiap item yang dipesan
                $data[$key][$category] += $item->qty;
            }
        }

        // Menyusun data untuk digunakan dalam chart
        $categories = array_unique(array_merge(...array_map('array_keys', array_values($data))));
        $series = [];
        foreach ($data as $key => $values) {
            $series[] = [
                'name' => $key,
                'data' => array_values(array_replace(array_fill_keys($categories, 0), $values))
            ];
        }

        // Ambil data pelanggan, jumlah order, produk, dan total keuntungan untuk ditampilkan
        $pelanggan = User::where('role_id', 2)->count();
        $order = Order::all()->count();
        $produk = Product::all()->count();
        $keuntungan = Transaction::sum('total_payment');

        $pieCategory = $this->categoryPie();

        $piePelanggan = $this->pelangganPie();
        $kotaPelanggan = $piePelanggan->groupBy('city_name');
        $labels = [];
        $dataLakilaki = [];
        $dataPerempuan = [];
        foreach ($kotaPelanggan as $city => $groupedData) {
            $labels[] = $city;
    
            $lakiLaki = $groupedData->where('jenis_kelamin', 'L')->sum('count');
            $perempuan = $groupedData->where('jenis_kelamin', 'P')->sum('count');
    
            $dataLakilaki[] = $lakiLaki;
            $dataPerempuan[] = $perempuan;
        }

        $preferensiGrafik = $this->preferensiPembelian($request);

        $grafikKeuntungan = $this->keuntungan($request);


        return view('admin.dashboard', [
            'pelanggan' => $pelanggan,
            'order'     => $order,
            'produk'    => $produk,
            'keuntungan' => $keuntungan,
            'series'    => json_encode($series), // Data untuk chart
            'categories' => json_encode($categories), // Kategori produk untuk sumbu X
            'pieCategory' => $pieCategory,
            'labels' => $labels,
            'dataLakilaki' => $dataLakilaki,
            'dataPerempuan' => $dataPerempuan,
            'kategori' => $preferensiGrafik['kategori'],
            'seri' => $preferensiGrafik['seri'],
            'dataKeuntungan' => $grafikKeuntungan['dataKeuntungan'],
            'bulanArray' => $grafikKeuntungan['bulanArray']


        ]);
    }

    private function categoryPie()
    {
        $categoryPie = Categories::pluck('category_name');
        return $categoryPie;
    }

    private function pelangganPie()
    {
        $pelanggan = User::where('role_id', 2)
            ->groupBy('city_name','jenis_kelamin')
            ->selectRaw('city_name, jenis_kelamin, COUNT(*) as count')
            ->get();

        return $pelanggan;
    }

    private function preferensiPembelian(Request $request)
    {
        $mulai = $request->input('mulai');
        $akhir = $request->input('akhir');


        $preferensi = Transaction::with(['user', 'order.order_items.product.categories'])
            ->whereHas('order.order_items.product.categories')
            ->when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
                $query->whereBetween('transaction_date', [$mulai, $akhir]);
            })->get();

        $data = [];

        foreach ($preferensi as $transaksi) {
            $pelanggan = $transaksi->user;
            $gender = $pelanggan->jenis_kelamin;
            $age = $pelanggan->umur;
            // Kategorisasi umur
            if ($age >= 12 && $age <= 19) {
                $ageGroup = 'R(12-19)';
            } elseif ($age >= 20 && $age <= 40) {
                $ageGroup = 'D(20-40)';
            } else {
                $ageGroup = 'OT(41-100)';
            }

            // Tentukan label berdasarkan kombinasi umur dan jenis kelamin
            $label = $ageGroup . ' ' . $gender;


            foreach ($transaksi->order->order_items as $item) {
                $category = $item->product->categories->category_name;

                if (!isset($data[$label][$category])) {
                    $data[$label][$category] = 0;
                }
                // Tambahkan jumlah transaksi untuk setiap kategori
                $data[$label][$category]++;
            }
        }

        // Ambil kategori produk dan hasilkan series data untuk chart
        $kategori = array_unique(array_merge(...array_map('array_keys', array_values($data))));
        $seri = [];

        foreach ($data as $key => $values) {
            $seri[] = [
                'name' => $key,
                'data' => array_values(array_replace(array_fill_keys($kategori, 0), $values))
            ];
        }

        return [
            'kategori' => $kategori,
            'seri' => $seri
        ];
    }

    private function keuntungan(Request $request)
    {
        $mulaiKeuntungan = $request->input('mulaiKeuntungan');
        $akhirKeuntungan = $request->input('akhirKeuntungan');

        // Filter transaksi berdasarkan tanggal
        $query = Transaction::query();
        if ($mulaiKeuntungan && $akhirKeuntungan) {
            $query->whereBetween('transaction_date', [$mulaiKeuntungan, $akhirKeuntungan]);
        }

        // Mengelompokkan berdasarkan bulan dan menghitung total_payment untuk setiap bulan
        $keuntungan = $query->selectRaw('MONTH(transaction_date) as bulan, SUM(total_payment) as total_keuntungan')
            ->groupBy('bulan')
            ->get();

        // Inisialisasi array untuk bulan dari Januari sampai Desember
        $bulanArray = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Data total keuntungan per bulan
        $dataKeuntungan = array_fill(0, 12, 0); // Inisialisasi semua bulan dengan 0

        // Isi data keuntungan sesuai bulan
        foreach ($keuntungan as $k) {
            $dataKeuntungan[$k->bulan - 1] = $k->total_keuntungan;
        }

        return [
            'dataKeuntungan' => $dataKeuntungan,
            'bulanArray' => $bulanArray
        ];
    }

    public function index(Request $request)
    {
        // Memeriksa apakah ada inputan tanggal
        if ($request->has(['tglAwal', 'tglAkhir'])) {
            $start_date = $request->input('tglAwal');
            $end_date = $request->input('tglAkhir');

            // Melakukan filter berdasarkan periode tanggal
            $transaksi = Order::where('status', 'success')->with('order_items.product', 'transaction', 'user')
                ->whereHas('transaction', function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('transaction_date', [$start_date, $end_date]);
                })
                ->get();
        } else {
            // Jika tidak ada inputan tanggal, ambil semua data transaksi
            $transaksi = Order::where('status', 'success')->with('order_items.product', 'transaction', 'user')->get();
        }

        return view('admin.laporan.laporan-admin', compact('transaksi'));
    }

    public function export(Request $request)
    {
        // Ambil input tanggal dari request
        $start_date = $request->input('tglAwal');
        $end_date = $request->input('tglAkhir');


        // Buat query untuk mengambil data transaksi
        $query = Order::where('status', 'success')->with('order_items.product', 'transaction', 'user');

        // Jika ada tanggal awal dan tanggal akhir yang diberikan, tambahkan filter tanggal
        if ($start_date && $end_date) {
            $query->whereHas('transaction', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('transaction_date', [$start_date, $end_date]);
            });
        }

        // Ambil data transaksi sesuai dengan query yang dibuat
        $laporan = $query->get();

        // Load view dan kirimkan data transaksi
        $pdf = PDF::loadView('admin.laporan.cetak-laporan', compact('laporan'));

        // Unduh PDF
        return $pdf->download('laporan-' . now()->timestamp . '.pdf');
    }

    public function rating()
    {
        $testimoni = Testimoni::with('order_item.product')->get();
        return view('admin.rating.rating', ['testimoni' => $testimoni]);
    }

    public function login()
    {
        return view('admin.login-admin');
    }

    public function dataUser()
    {
        $user = User::where('role_id', '2')->get();
        return view('admin.user.dataUser', ['user' => $user]);
    }

    public function editUser(Request $request, $id)
    {
        $editUser = User::findOrFail($id);
        return view('admin.user.dataUser-edit', ['editUser' => $editUser]);
    }

    public function updateData(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);


        $editUser = User::findOrFail($id);


        $editUser->name = $request->name;
        $editUser->email = $request->email;
        $editUser->umur = $request->umur;
        $editUser->jenis_kelamin = $request->jenis_kelamin;
        $editUser->alamat = $request->alamat;


        $editUser->save();


        return redirect('/dataUser-admin');
    }


    public function ekspedisi(Request $request)
    {
        // Validasi data
        $request->validate([
            'pesan' => 'required|string',
        ]);

        
        $chat = new Chat();
        $chat->pesan = $request->pesan;
        $chat->save();

        return redirect('/');
    }

    public function chat_ekspedisi()
    {
        $chat = Chat::all();
        return view('admin.layouts.navbar', ['chat' => $chat]);
    }

    public function index_ekspedisi()
    {
        $ekspedisi = Order::where('status', 'success')->with('user', 'order_items.product')->get();

        return view('ekspedisi.pesanan', ['ekspedisi' => $ekspedisi]);
    }


    public function editResi($id)
    {
        $edit = Order::with('user', 'order_items.product')->findOrFail($id);
        return view('ekspedisi.update-resi', ['edit' => $edit]);
    }

    public function resi(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|string',
            'order_date' => 'required|date',
            'status' => 'required',
            'status_pesanan' => 'required',
            'resi' => 'required|string',
            'total_weight' => 'required|numeric', 
            'total_price' => 'required|string'
        ]);


   


        $updateResi = Order::where('status','success')->with(['order_items.product'])->findOrFail($id);



        $totalPrice = (int) str_replace(['Rp. ', ','], '', $updateResi->total_price);

        $updateResi->user_id= $request->user_id;
        $updateResi->order_date = $request->order_date;
        $updateResi->status = $request->status;
        $updateResi->status_pesanan = $request->status_pesanan;
        $updateResi->resi = $request->resi;
        $updateResi->total_weight = $request->total_weight;
        $updateResi->total_price = $totalPrice;

        $updateResi->save();

        $chats = Chat::all();
        foreach ($chats as $chat) {
            $chat->delete();
        }


        return redirect('/ekspedisi-pesanan'); 
    }
}
