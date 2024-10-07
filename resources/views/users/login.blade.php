@extends('users.layouts.index')
@section('title', 'Login')
@section('content')
    <div class="container">
        <div class="judul">
            <h3 class="text-center mt-4 text-primary" style=" font-family: 'Poppins', sans-serif;">Login</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6" style="margin-top: 50px">
                <div class="form-container shadow p-4 rounded">
                    @if (Session::has('status'))
                    <div class="alert alert-primary " role="alert">
                        {{ Session::get('message')}}
                      </div>
                    @endif
                    <form method="post" action="/login">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="text-center mt-3">
                            <p class="mb-3">Belum punya akun?</p>
                            <a href="/register">Daftar disini!</a>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary col-md-12 mt-2">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
