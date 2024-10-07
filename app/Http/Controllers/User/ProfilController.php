<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_items;
use Illuminate\Support\Facades\Http;
use App\Models\Testimoni;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $province = $this->get_province();


        // Kirim data ke view
        return view('users.profil', ['user' => $user, 'province' => $province,]);
    }

    public function get_province()
    {
        $response = Http::asForm()->withHeaders([
            'key' => 'e36a143f6a692a3a859420f7a6feff66',
        ])->get('https://api.rajaongkir.com/starter/province');
        return $response['rajaongkir']['results'];
    }

    public function get_cities($provinceId)
    {
        $response = Http::asForm()->withHeaders([
            'key' => 'e36a143f6a692a3a859420f7a6feff66',
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $provinceId
        ]);
        return response()->json($response['rajaongkir']['results']);
    }



    public function update(Request $request)
    {
        // Validasi input dari formulir
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'umur' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|in:L,P',
            'provinsi_id' => 'nullable|integer',
            'kota_id' => 'nullable|integer',
            'province_name' => 'nullable|string',
            'city_name' => 'nullable|string',
            'alamat' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk file foto
        ]);

        // Ambil data pengguna yang akan diperbarui
        $user = User::findOrFail(auth()->user()->id);

        // Periksa apakah input password tidak kosong
        if (!empty($request->password)) {
            // Jika tidak kosong, update password
            $user->password = bcrypt($request->password);
        }

        // Update data pengguna lainnya
        $user->name = $request->name;
        $user->email = $request->email;
        $user->umur = $request->umur;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->provinsi_id = $request->provinsi_id;
        $user->kota_id = $request->kota_id;
        $user->province_name = $request->province_name;
        $user->city_name = $request->city_name;
        $user->alamat = $request->alamat;

        // Periksa apakah file foto diunggah
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('foto_profil');
            $user->foto = $path;
        }

        $user->save();

        return redirect('/profil');
    }


    public function transaksi()
    {
        $transaksi = Transaction::whereHas('order', function (Builder $builder) {
            $builder
                ->where('user_id', Auth::user()->id)
                ->where('status', 'success');
        })
            ->with('order.order_items.product', 'order.order_items.testimoni')
            ->get();


        return view('users.transaksi', compact('transaksi'));
    }

    public function pesanan()
    {
        $user = Auth::user();
        $pesanan = Order::where('user_id', $user->id)
            ->with('transaction', 'order_items.product')
            ->get();

        return view('users.pesanan', compact('user', 'pesanan'));
    }


    public function testimoni(Request $request, Order_items $oi)
    {
        $testi = new Testimoni();
        $testi->user_id = $request->user()->id;
        $testi->order_item_id = $oi->id;
        $testi->testimoni = $request->input('testimoni');
        $testi->rating = $request->input('rating');
        $testi->save();

        return redirect('/transaksi-user');
    }
}
