@extends('admin.layouts.home')
@section('title', 'admin-rating')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-center text-gray-800 ">Rating </h1>
        {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> --}}

        <!-- DataTales Example -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Product Name</th>
                            <th>Testimoni</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimoni as $testi)
                            <tr>
                                <td>{{ $loop->iteration }}</td> <!-- Iterasi dari orderItems loop -->
                                <td>{{ $testi->user->name }}</td>
                                <td>{{ $testi->order_item->product->product_name }}</td>
                                <td>{{ $testi->testimoni }} </td>
                                <td>{{ $testi->rating }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
