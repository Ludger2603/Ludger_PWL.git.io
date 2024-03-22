@extends('layout.login')
@section('judul','Register User Baru')

@section('content')
    <p class="login-box-msg">Registrasi User Baru</p>
    <form action="" method="post">
        @csrf
        <div class="form-group">
            <label for="">Nama</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
            @error('name') 
            <div class="invalid-feedback">
            {{$message}}
            </div>
             @enderror
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
            @error('email') 
            <div class="invalid-feedback">
            {{$message}}
            </div>
             @enderror
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password') 
            <div class="invalid-feedback">
            {{$message}}
            </div>
             @enderror
        </div>
        <button class="btn btn-primary btn-block" type="submit">Register</button>
        <a href="/login" class="btn btn-info btn-block">Kembali</a>
    </form>
@endsection
