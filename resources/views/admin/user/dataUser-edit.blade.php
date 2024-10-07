@extends('admin.layouts.home')
@section('title', 'DataUser-edit')
@section('content')
    <div class="container-fluid">
        <form action="/dataUser-edit/{{ $editUser->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label ">Nama </label>
                <input type="text" class="form-control col-8" id="name" name="name" value="{{ $editUser->name }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label ">Email</label>
                <input type="email" class="form-control col-8" id="email" value="{{ $editUser->email }}"
                    name="email">
            </div>
            <div class="mb-3">
                <label for="umur" class="form-label ">Umur</label>
                <input type="number" class="form-control col-8" id="umur" value="{{ $editUser->umur }}"
                    name="umur">
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-control col-8" id="jenis_kelamin" name="jenis_kelamin">
                    <option value="L" {{ $editUser->jenis_kelamin == 'LAKI-LAKI' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="P" {{ $editUser->jenis_kelamin == 'PEREMPUAN' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control col-8" id="alamat" name="alamat" rows="4">{{ $editUser->alamat }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Edit Data</button>
        </form>
    </div>
@endsection
