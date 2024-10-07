@extends('users.layouts.index')
@section('title', 'profil')
@section('content')
    <div class="container">
        <div class="main-body">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="/update-foto/{{ $user->id }}" method="post">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ asset('storage/' . $user->foto) }}" width="100px" alt="Admin"
                                        class="rounded-circle" width="150">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <a href="/transaksi-user" class="mb-0 text-decoration-none">Transaksi</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <a href="/pesanan-user" class="mb-0 text-decoration-none">Order</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <a href="" class="mb-0 text-decoration-none">Profil</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Nama</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->email }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Umur</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->umur }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Jenis Kelamin</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->jenis_kelamin }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Alamat</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->alamat }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Provinsi</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                 {{ $user->province_name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Kota</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                 {{ $user->city_name }}
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <a class="btn btn-info" href="#" data-toggle="modal"
                                        data-target="#editModal">Edit</a>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Isi dengan form edit profil -->
                                                <form method="POST" action="/profil" enctype="multipart/form-data">
                                                    <input type="hidden" name="province_name" id="province_name" value="">
                                                    <input type="hidden" name="city_name" id="city_name" value="">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name">Nama</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" placeholder="Masukan nama..." value="{{ $user->name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email"
                                                            name="email" placeholder="Masukan email..." value="{{ $user->email }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input type="password" class="form-control" id="password"
                                                            name="password" placeholder="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="umur">Umur</label>
                                                        <input type="number" class="form-control" id="umur"
                                                            name="umur" placeholder="Masukan umur..." value="{{ $user->umur }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jenis Kelamin</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="jenis_kelamin" id="laki_laki" value="L">
                                                            <label class="form-check-label"
                                                                for="laki_laki">Laki-laki</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="jenis_kelamin" id="perempuan" value="P">
                                                            <label class="form-check-label"
                                                                for="perempuan">Perempuan</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="alamat">Alamat</label>
                                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukan alamat...">{{ $user->alamat }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="provinsi">Provinsi</label>
                                                        <select name="provinsi_id" id="province_id" class="form-control">
                                                            <option value="">Pilih Provinsi</option>
                                                            @foreach ($province as $provinsi)
                                                                <option value="{{ $provinsi['province_id'] }}" data-name="{{ $provinsi['province'] }}">
                                                                    {{ $provinsi['province'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="kota_id">Kota</label>
                                                        <select name="kota_id" id="kota_id" class="form-control">
                                                            <option value="">Pilih Kota</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="foto">Foto</label>
                                                        <input type="file" class="form-control" id="foto"
                                                            name="foto">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @section('js')
    <script>
        $(document).ready(function() {
            $('#province_id').on('change', function() {
                let provinceName = $(this).find(':selected').data('name');
                let provinceId = $(this).val();
                $('#province_name').val(provinceName);

                if (provinceId) {
                    $.ajax({
                        url: `/city/${provinceId}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kota_id').empty().append('<option value="">Pilih Kota</option>');
                            $.each(data, function(key, value) {
                                $('#kota_id').append('<option value="' + value.city_id + '" data-name="' + value.city_name + '">' + value.city_name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                } else {
                    $('#kota_id').empty().append('<option value="">Pilih Kota</option>');
                }
            });

            $('#kota_id').on('change', function() {
                let cityName = $(this).find(':selected').data('name');
                $('#city_name').val(cityName);
            });
        });
    </script>
    @endsection