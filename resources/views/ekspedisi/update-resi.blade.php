@extends('admin.layouts.home')
@section('title', 'update-resi')
@section('content')
    <div class="container-fluid">
        <form action="/update-resi/{{ $edit->id }}" method="POST">
            <input type="hidden" name="user_id" value="{{ $edit->user_id }}">
            <input type="hidden" name="total_weight" value="{{ $edit->total_weight }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <h2 class="mb-4 text-center">Update Resi</h2>
            </div>
        
            @foreach ($edit->order_items as $index => $item)
                <div class="mb-3">
                    <label for="product_name_{{ $index }}" class="form-label">Product Name</label>
                    <input type="text" class="form-control col-8" id="product_name_{{ $index }}" name="product_names[]"
                        value="{{ $item->product->product_name }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="product_price_{{ $index }}" class="form-label">Product Price</label>
                    <input type="text" class="form-control col-8" id="product_price_{{ $index }}" name="product_prices[]"
                        value="{{ $item->product->product_price }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="size_{{ $index }}" class="form-label">Size</label>
                    <input type="text" class="form-control col-8" id="size_{{ $index }}" name="sizes[]"
                        value="{{ $item->size }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="qty_{{ $index }}" class="form-label">Quantity</label>
                    <input type="number" class="form-control col-8" id="qty_{{ $index }}" name="quantities[]"
                        value="{{ $item->qty }}" readonly>
                </div>
            @endforeach
        
            <div class="mb-3">
                <label for="order_date" class="form-label">Order Date</label>
                <input type="text" class="form-control col-8" id="order_date" name="order_date"
                    value="{{ $edit->order_date }}" readonly>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control col-8" id="status" name="status"
                    value="{{ $edit->status }}" readonly>
            </div>
            <div class="mb-3">
                <label for="status_pesanan" class="form-label">Status Pesanan</label>
                <select class="form-control col-8" id="status_pesanan" name="status_pesanan">
                    <option value="pending" {{ $edit->status_pesanan === 'pending' ? 'selected' : '' }}>pending</option>
                    <option value="dikirim" {{ $edit->status_pesanan === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="resi" class="form-label">Input Resi</label>
                <input type="text" class="form-control col-8" id="resi" name="resi">
            </div>
            <div class="mb-3">
                <label for="total_price" class="form-label">Total Price</label>
                <input type="text" class="form-control col-8" id="total_price" name="total_price"
                    value="RP.{{ number_format($edit->total_price) }}" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        

    </div>
@endsection
