@extends('layout.main')
@section('judul','Data Motor')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('admin')
                    <a class="btn btn-primary mb-2" href="{{url('/motor/add')}}">Tambah Data Motor</a>
                    @endcan
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Merek</th>
                                <th>Tahun</th>
                                <th>Harga Per Hari</th>
                                <th>Denda Per Hari</th>
                                <th>Stok</th>
                                <th>Nomor Plat</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = (($motors->currentPage() -1)* $motors->perPage())+1;
                            @endphp
                            @foreach($motors as $row)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td><img src="{{route('storage',$row->gambar)}}" width="50px" height="50px"></td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->type}}</td>
                                    <td>{{$row->year}}</td>
                                    <td>Rp {{$row->price_per_day}}</td>
                                    <td>Rp {{$row->denda}}</td>
                                    <td>{{$row->availability}}</td>
                                    <td>{{$row->no_plat}}</td>
                                    @can('admin')
                                    <td>
                                        <button type="button" data-id-motor="{{$row->id}}" data-name="{{$row->name}}" class="btn btn-danger btn-sm btn-hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <!-- Modal Trigger Button -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$row->id}}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @endcan
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{$row->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$row->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{$row->id}}">Edit Data Pengguna</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form untuk mengedit data pengguna -->
                                                        <form method="post" action="{{url('motor/update')}}" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$row->id}}"/>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="mb-3">
                                                                                <label for="form-label">Gambar</label>
                                                                                <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" 
                                                                                accept="image/*" onchange="tampilkanPreview(this, 'tampilFoto')" value="{{$row->gambar}}">
                                                                                @error('gambar')
                                                                                <span style="color:red; font-wight: 600; font-size: 9pt">{{$message}}</span>
                                                                                @enderror
                                                                                <p></p>
                                                                                <img id="tampilFoto" onerror="this.onerror=null; this.src='https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABLN930GwaMQz.jpg'; " src="{{route('storage',$row->gambar)}}" alt="" width="15%">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">no_plat</label>
                                                                                <input type="text"
                                                                                       class="form-control @error('no_plat') is-invalid @enderror"
                                                                                       value="{{$row->no_plat}}"
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
                                                                                       value="{{$row->name}}"
                                                                                       name="name">
                                                                                @error('name')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Merek</label>
                                                                                <input type="text"
                                                                                       class="form-control @error('type') is-invalid @enderror"
                                                                                       value="{{$row->type}}"
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
                                                                                       value="{{$row->year}}"
                                                                                       name="year">
                                                                                @error('year')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Harga Per Hari</label>
                                                                                <input type="price_per_day"
                                                                                       class="form-control @error('price_per_day') is-invalid @enderror"
                                                                                       value="{{$row->price_per_day}}"
                                                                                       name="price_per_day">
                                                                                @error('price_per_day')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="availability">Ketersediaan</label>
                                                                                <select id="availability" name="availability" class="form-control @error('availability') is-invalid @enderror">
                                                                                    <option value="Tersedia" {{ $row->availability === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                                                    <option value="Sold Out" {{ $row->availability === 'Sold Out' ? 'selected' : '' }}>Tidak Tersedia</option>
                                                                                </select>
                                                                                @error('availability')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Denda</label>
                                                                                <input type="denda"
                                                                                       class="form-control @error('denda') is-invalid @enderror"
                                                                                       value="{{$row->denda}}"
                                                                                       name="denda">
                                                                                @error('denda')
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$motors->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function () {
            $('.btn-hapus').on('click', function () {
                let idMotor = $(this).data('id-motor');
                let name = $(this).data('name');
                Swal.fire({
                    title: "Konfirmasi",
                    text: `Anda yakin hapus data ${name}?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/motor/delete',
                            type: 'POST',
                            data: {
                                _token: '{{csrf_token()}}',
                                id: idMotor
                            },
                            success: function () {
                                Swal.fire('Sukses', 'Data berhasil dihapus', 'success')
                                    .then(function () {
                                        window.location.reload();
                                    })
                            },
                            error: function () {
                                Swal.fire('Gagal', 'Terjadi kesalahan ketika hapus data', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
    @if(Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}");
    </script>
@endif

@if(Session::has('error'))
    <script>
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif

@endpush
