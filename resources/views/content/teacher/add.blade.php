@extends('layout.main')
@section('judul','Tambah Data Teacher')

@section('content')
    {{--    @if ($errors->any())--}}
    {{--        <div class="alert alert-danger">--}}
    {{--            <ul>--}}
    {{--                @foreach ($errors->all() as $error)--}}
    {{--                    <li>{{ $error }}</li>--}}
    {{--                @endforeach--}}
    {{--            </ul>--}}
    {{--        </div>--}}
    {{--    @endif--}}
    <form method="post" action="{{url('teacher/insert')}}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{old('name')}}"
                                   name="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{old('email')}}"
                                   name="email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Date of Birth</label>
                            <input type="date"
                                   class="form-control @error('dob') is-invalid @enderror"
                                   value="{{old('dob')}}"
                                   name="dob">
                            @error('dob')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
