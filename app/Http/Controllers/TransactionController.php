<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(){
        $transaksi = Order::with('order_items.product', 'transaction', 'user' )->get();
        return view('admin.transaksi.transaksi', ['transaksi' => $transaksi]);
    }
    
}
