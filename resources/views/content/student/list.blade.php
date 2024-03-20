@extends('layout.main')
@section('judul','Data Student')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary mb-2" href="{{url('/student/add')}}">Tambah Data Student</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Lahir</th>
                                <th>Dosen Pembimbing</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = (($students->currentPage() -1)* $students->perPage())+1;
                            @endphp
                            @foreach($students as $student)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->email}}</td>
                                    <td>{{$student->dob}}</td>
                                    <td>{{$student->teacher->name}}</td>
                                    <td>
                                        <a class="btn btn-warning btn-sm"
                                           href="{{url('student/edit/'.$student->id)}}">
                                            <i class="fas fa-edit  "></i>
                                        </a>
                                        <button type="button"
                                                data-id-student="{{$student->id}}"
                                                data-name="{{$student->name}}"
                                                class="btn btn-danger btn-sm btn-hapus">
                                            <i class="fas fa-trash  "></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$students->links()}}
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
                let idStudent = $(this).data('id-student');
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
                            url: '/student/delete',
                            type: 'POST',
                            data: {
                                _token: '{{csrf_token()}}',
                                id: idStudent
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
@endpush
