@extends('layout.login')

@section('judul', 'login')

@section('content')
<p class="login-box-msg">Silahkan Masukan Email Dan Password Anda </p>
<form action="/login/verify" method="post">
    @csrf
    <div class="input-group mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-envelope"></span>
        </div>
      </div>
    </div>
    <div class="input-group mb-3">
      <input type="password" name="password" class="form-control" placeholder="Password">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
@endsection
@push('js')
    <script>
        $(function () {
            @if(Session::has('gagal'))
            toastr.error('{{Session::get('gagal')}}', 'Login Error')
            @endif
        });
    </script>
@endpush
