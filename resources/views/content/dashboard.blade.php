@extends('layout.main')
@section('judul','Dashboard')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Total User</p>
                  <h5 class="font-weight-bolder mb-0">
                    {{$user}}
                    <span class="text-success text-sm font-weight-bolder">User</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Motor</p>
                  <h5 class="font-weight-bolder mb-0">
                    {{$motor}}
                    <span class="text-success text-sm font-weight-bolder">Motor</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Persyaratan Peminjaman
                  </button>                  
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
          <!-- Add Modal Here -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Persyaratan Peminjaman</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <!-- Modal Content Goes Here -->
                  {{$syarat->keterangan}}
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End of Modal -->
        </div>
        <!-- Button trigger modal -->
        <!-- End of Button -->
      </div>
      
      <div class="col-xl-3 col-sm-6">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pesanan saat Ini</p>
                  <h5 class="font-weight-bolder mb-0">
                    {{$pesanan}}
                    <span class="text-success text-sm font-weight-bolder">Pesanan Saat ini</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      @foreach ($kendaraan as $row)
      <div class="col-lg-2 mb-5 mt-3">
          <div class="card h-100 shadow border-0">
              <img class="card-img-top" src="{{route('storage',$row->gambar)}}" alt="{{$row->name}}" />
              <div class="card-body p-4">
                  <div class="badge bg-primary bg-gradient rounded-pill mb-2">{{$row->availability}}</div>
                  <a>
                      <div class="h5 card-title mb-3">
                          {{$row->name}}
                      </div>
                  </a>
                  <!-- Tombol "Pesan Motor" -->
                  @if ($row->availability == 'Tersedia')
                      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$row->id}}">Pesan Motor</button>
                  @else
                      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#notAvailableModal{{$row->id}}">Motor Tidak Tersedia</button>
                  @endif
              </div>
              <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                  <div class="d-flex align-items-end justify-content-between">
                      <div class="d-flex align-items-center">
                          <div class="small">
                              <div class="fw-bold">{{$row->type}}</div>
                              <div class="text-muted">{{$row->created_at}}</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade" id="notAvailableModal{{$row->id}}" tabindex="-1" aria-labelledby="notAvailableModalLabel{{$row->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notAvailableModalLabel{{$row->id}}">Motor Tidak Tersedia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Konten untuk modal motor tidak tersedia -->
                    <p>Motor {{$row->name}} sedang tidak tersedia saat ini. Silakan coba lagi nanti.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal{{$row->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$row->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{$row->id}}">Pesan Motor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{url('pesanan/insert')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$row->id}}"/>
                        <!-- Formulir Pesanan Motor -->
                        <div class="form-group">
                          <label for="">no_plat</label>
                          <input type="text"
                                 class="form-control @error('no_plat') is-invalid @enderror"
                                 value="{{$row->no_plat}}"
                                 name="no_plat" readonly>
                          @error('no_plat')
                          <div class="invalid-feedback">
                              {{$message}}
                          </div>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="">Nama Motor</label>
                        <input type="text"
                               class="form-control @error('name_motor') is-invalid @enderror"
                               value="{{$row->name}}"
                               name="name_motor" readonly>
                        @error('name_motor')
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
                                 placeholder="silahkan masukan nama lengkap"
                                 name="name">
                          @error('name')
                          <div class="invalid-feedback">
                              {{$message}}
                          </div>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="">Lama Sewa</label>
                          <input type="text"
                                 class="form-control @error('lama_sewa') is-invalid @enderror"
                                 value="{{$row->lama_sewa}}"
                                 name="lama_sewa">
                          @error('lama_sewa')
                          <div class="invalid-feedback">
                              {{$message}}
                          </div>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="">Keterangan</label>
                          <textarea type="text"
                                 class="form-control @error('keterangan') is-invalid @enderror"
                                 value="{{$row->keterangan}}"
                                 name="keterangan"></textarea>
                          @error('keterangan')
                          <div class="invalid-feedback">
                              {{$message}}
                          </div>
                          @enderror
                      </div>
                      <div class="form-group">
                        <input type="hidden"
                               class="form-control @error('id_user') is-invalid @enderror"
                               value="{{$userT->id}}"
                               name="id_user">
                        @error('id_user')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                        <!-- Tambahkan input lainnya sesuai kebutuhan -->
                        <button class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
</div>
<footer>
  Ludger Rental
</footer>
@endsection
@push('js')
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