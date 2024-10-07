@extends('users.layouts.index')
@section('title', 'registrasi')
@section('content')
    <div class="container">
        <div class="judul">
            <h3 class="text-center mt-4 text-primary" style=" font-family: 'Poppins', sans-serif;">Registrasi </h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 order-md-last">
                <img src="{{ asset('user/img/banner/tfo.png') }}" style="margin-left: 150px; margin-top: 150px" alt="Placeholder Image" class="img-fluid">
            </div>
            <div class="col-md-6" style="margin-top: 50px">
                <!-- Form ditempatkan di sisi kanan -->
                <div class="form-container shadow p-4 rounded">
                    <h2 class="text-center mb-5">Daftar Sekarang</h2>
                    <form method="post" action="/registrasi">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" id="alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">  
                            <label for="umur" class="form-label">Umur</label>
                            <input type="number" name="umur" id="umur" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="L">
                                <label class="form-check-label" for="laki_laki">
                                    Laki-laki 
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P">
                                <label class="form-check-label" for="perempuan">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary col-md-12">Daftar</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p class="mb-0">Sudah punya akun?</p>
                        <a href="/login">Masuk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
