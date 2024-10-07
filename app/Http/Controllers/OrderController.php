<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Order;
use App\Models\Order_items;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orderItems = Order_items::with('order.user', 'product')->get();
        return view('admin.order.order', ['orderItems' => $orderItems]);
    }

    public function edit(Request $request, $id)
    {
        $edit = Order::with('user', 'order_items.product')->findOrFail($id);
        return view('admin.order.order-edit', ['edit' => $edit]);
    }

    public function update(Request $request, $id)
    {

    }
}
