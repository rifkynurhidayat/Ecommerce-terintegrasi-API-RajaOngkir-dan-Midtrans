<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingDiscOngkirController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\User\ProdukController;
use App\Http\Controllers\User\OrdersController;
use App\Http\Controllers\User\ProfilController;
use App\Http\Controllers\User\RegistrasiController;
use App\Http\Controllers\User\TransactionUserController;
use App\Http\Middleware\IsAdmin;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'IsAdmin'])->group(function () {

    Route::get('/product', function () {
        return view('users.product');
    });
    Route::get('/produk', [ProductController::class, 'index']);
    Route::get('/produk-add', [ProductController::class, 'create']);
    Route::get('/produk-edit/{id}', [ProductController::class, 'edit']);
    Route::get('/produk-delete/{id}', [ProductController::class, 'delete']);
    Route::post('/produk', [ProductController::class, 'store']);
    Route::put('/produk/{id}', [ProductController::class, 'update']);

    Route::get('/kategori', [CategoriesController::class, 'index']);
    Route::get('/kategori-add', [CategoriesController::class, 'create']);
    Route::post('/kategori', [CategoriesController::class, 'store']);
    Route::get('/kategori/{id}', [CategoriesController::class, 'edit']);
    Route::put('/kategori/{id}', [CategoriesController::class, 'update']);
    Route::get('/kategori-delete/{id}', [CategoriesController::class, 'delete']);

    Route::get('/order-admin', [OrderController::class, 'index']);
    Route::get('/order-admin-edit/{id}', [OrderController::class, 'edit']);

    Route::put('/order-admin-update/{id}', [OrderController::class, 'update']);

    Route::get('/', [DashboardAdminController::class, 'home']);
    Route::get('/preferensi-pembelian', [DashboardAdminController::class, 'prefensiPembelianPelanggan'])->name('preferensi-pembelian');
    
    Route::get('/dataUser-admin', [DashboardAdminController::class, 'dataUser']);
    Route::get('/dataUser-edit/{id}', [DashboardAdminController::class, 'editUser']);
    Route::put('/dataUser-edit/{id}', [DashboardAdminController::class, 'updateData']);

    Route::get('/rating-admin', [DashboardAdminController::class, 'rating']);

    Route::get('/laporan-admin', [DashboardAdminController::class, 'index']);
    Route::get('/export-pdf', [DashboardAdminController::class, 'export']);

    Route::get('/transaksi-admin', [TransactionController::class, 'index']);

    Route::get('/setting-disc-ongkir', [SettingDiscOngkirController::class, 'edit'])->name('setting-disc-ongkir');
    Route::post('/setting-disc-ongkir', [SettingDiscOngkirController::class, 'update']);

    Route::post('/ekspedisi', [DashboardAdminController::class, 'ekspedisi']);

    Route::get('/ekspedisi-pesanan', [DashboardAdminController::class, 'index_ekspedisi']);
    Route::get('/ekspedisi-resi/{id}', [DashboardAdminController::class, 'editResi']);
    Route::put('/update-resi/{id}', [DashboardAdminController::class, 'resi']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/order/{id}', [OrdersController::class, 'order']);
    Route::get('/order', [OrdersController::class, 'addOrder']);
    Route::delete('/batal-order/{id}', [OrdersController::class, 'batal']);
    Route::PUT('/update-order/{id}', [OrdersController::class, 'update']);

    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::get('/checkout/{id}', [CheckoutController::class, 'addCheckout']);
    Route::get('/province', [CheckoutController::class, 'get_province']);
    Route::get('/city/{proviceId}', [CheckoutController::class, 'get_cities']);
    Route::get('/origin={city_origin}&destination={city_destination}&weight={weight}&courier={courier}',  [CheckoutController::class, 'get_ongkir']);

    Route::post('/transaction/{id}', [TransactionUserController::class, 'transaction']);
    Route::post('/transaction/getSnapToken/{id}', [TransactionUserController::class, 'getSnapToken']);

    Route::get('/invoice/{id}', [TransactionUserController::class, 'invoice']);

    Route::get('/profil', [ProfilController::class, 'index']);
    Route::get('/province', [ProfilController::class, 'get_province']);
    Route::get('/city/{provinceId}', [ProfilController::class, 'get_cities']);
    
    Route::post('/profil', [ProfilController::class, 'update']);
    Route::get('/transaksi-user', [ProfilController::class, 'transaksi']);
    Route::get('/pesanan-user', [ProfilController::class, 'pesanan']);
    Route::post('/testimoni/{oi}', [ProfilController::class, 'testimoni']);

    Route::get('/produk-preferensi', [ProdukController::class, 'preferensi']);
});
Route::get('/profil-toko', function () {
    return view('users.profil-toko');
});
Route::get('/home', [ProdukController::class, 'index'])->name('home');
Route::get('/produk-detail/{id}', [ProdukController::class, 'detail']);
Route::get('/produk-unggulan', [ProdukController::class, 'unggulan']);
Route::get('/produk-rating-tertinggi', [ProdukController::class, 'rating_tertinggi']);
Route::get('/produk-sering-dilihat', [ProdukController::class, 'sering_dilihat']);

Route::get('/register', [RegistrasiController::class, 'index']);
Route::post('/registrasi', [RegistrasiController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
