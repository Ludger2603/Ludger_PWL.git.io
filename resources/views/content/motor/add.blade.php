@extends('layout.main')
@section('judul','Tambah Data Product')

@section('content')
    <form method="post" action="{{url('motor/insert')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="mb-3">
                            <label for="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" 
                            accept="image/*" onchange="tampilkanPreview(this, 'tampilFoto')">
                            @error('gambar')
                            <span style="color:red; font-wight: 600; font-size: 9pt">{{$message}}</span>
                            @enderror
                            <p></p>
                            <img id="tampilFoto" onerror="this.onerror=null; this.src='https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABLN930GwaMQz.jpg'; " src="" alt="" width="15%">
                        </div>
                        <div class="form-group">
                            <label for="">Nomor Plat</label>
                            <input type="text"
                                   class="form-control @error('no_plat') is-invalid @enderror"
                                   value="{{old('no_plat')}}"
                                   name="no_plat">
                            @error('no_plat')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
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
                            <label for="">Merek Motor</label>
                            <input type="text"
                                   class="form-control @error('type') is-invalid @enderror"
                                   value="{{old('type')}}"
                                   name="type">
                            @error('type')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Tahun</label>
                            <input type="text"
                                   class="form-control @error('year') is-invalid @enderror"
                                   value="{{old('year')}}"
                                   name="year">
                            @error('year')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Harga Sewa Perhari</label>
                            <input type="price_per_day"
                                   class="form-control @error('price_per_day') is-invalid @enderror"
                                   value="{{old('price_per_day')}}"
                                   name="price_per_day">
                            @error('price_per_day')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Denda Perhari</label>
                            <input type="denda"
                                   class="form-control @error('denda') is-invalid @enderror"
                                   value="{{old('denda')}}"
                                   name="denda">
                            @error('denda')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="availability">Ketersediaan</label>
                            <select id="availability" name="availability" class="form-control @error('availability') is-invalid @enderror">
                                <option value="Tersedia" {{ old('availability') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Sold Out" {{ old('availability') == 'Sold Out' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                            @error('availability')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
