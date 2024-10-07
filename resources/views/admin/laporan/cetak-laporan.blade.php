<!-- cetak-laporan.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2  class="text-center">Laporan Pendapatan Teras Factory Outlet</h2>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Nama Produk</th>
                <th>Ukuran</th>
                <th>QTY</th>
                <th>Tanggal Transaksi</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $trans)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $trans->user->name }}</td>
                    <td>
                        @foreach ($trans->order_items as $item)
                            {{ $item->product->product_name }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($trans->order_items as $item)
                            {{ $item->size }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($trans->order_items as $item)
                            {{ $item->qty }}<br>
                        @endforeach
                    </td>
                    <td>{{ $trans->transaction->transaction_date }}</td>
                    <td>Rp.{{ number_format($trans->transaction->total_payment) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" class="text-end"><strong>Total pendapatan:</strong></td>
                <td><strong>Rp.{{ number_format($laporan->sum('transaction.total_payment')) }}</strong></td>

            </tr>
        </tbody>
    </table>
                      
</body>
</html>
