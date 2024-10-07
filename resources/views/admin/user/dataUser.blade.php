@extends('admin.layouts.home')
@section('title', 'Data User')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800 ">User </h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> --}}

  
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama </th>
                            <th>Email</th>
                            <th>Umur</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $pel)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pel->name }}</td>
                                    <td>{{ $pel->email }}</td>
                                    <td>{{ $pel->umur }}</td>
                                    <td>{{ $pel->jenis_kelamin }}</td>
                                    <td>{{ $pel->alamat }}</td>
                                    <td>
                                        <a href="/dataUser-edit/{{ $pel->id }}"
                                            class="m-0 font-weight-bold text-decoration-none text-primary">Edit</a>
                                    </td>
                                </tr>     
                        @endforeach
                    </tbody>
                </table>
                
                
            </div>
        </div>
    @endsection
