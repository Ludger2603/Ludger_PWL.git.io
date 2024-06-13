@extends('layout.main')
@section('judul','Pemesanan Motor')
@section('content')

    <div class="row">
        <div class="col-12">
            <input type="text" id="input-barcode" name="barcode"
                   class="form-control" placeholder="masukan nomor plat kendaraan"/>
        </div>
    </div>
    <form method="post" action="{{url('/app/insert')}}">
        <div class="row">
            @csrf
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="table-cart">
                            <thead>
                            <tr>
                                <th>Plat</th>
                                <th>Nama</th>
                                <th>Harga sewa</th>
                                <th>Lama Sewa</th>
                                <th>Total Harga Sewa</th>
                                <th>denda <br>1 jam</th>
                                <th>denda <br>3 jam</th>
                                <th>denda <br>5 jam</th>
                                <th>denda <br>1 hari</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="card">
                    <div class="card-body">
                        <table width="100%">
                            </tr>
                                <td>
                                    <label for="">Harga Sewa Perhari</label>
                                    <input type="text" readonly name="subtotal" id="subtotal" 
                                        class="form-control text-right">
                                </td>
                            </tr>
                            </tr>
                                <td >
                                    <label for="">Hitungan Kurang Dari 24 jam Sewa (%)</label>
                                    <input type="number" min="0" max="100" name="discount" id="discount" 
                                        class="form-control text-right"
                                        value='0'>
                                </td>
                            </tr>
                            </tr>
                                <td >
                                    <label for="">Total</label>
                                    <input type="text" readonly name="total" id="total" 
                                        class="form-control text-right">
                                </td>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('js')
    <script>
        $(function () {
            $('#input-barcode').on('keypress', function (e) {
                if (e.which === 13) {
                    console.log('Enter di klik');
                    //pencarian data via ajax
                    $.ajax({
                        url: '/app/search-barcode',
                        type: 'POST',
                        data: {
                            _token: '{{csrf_token()}}',
                            no_plat: $(this).val()
                        },
                        success: function (data) {
                            addProductToTable(data);
                            toastr.success('Detail Rental berhasil ditambahkan', 'Berhasil');
                            $('#input-barcode').val('');

                        },
                        error: function () {
                            toastr.error('nomor Plat yang dicari tidak ditemukan', 'Error');
                            $('#input-barcode').val('');
                        }
                    })
                }
            });

            function addProductToTable(motor) {
                let rowExist = $('#table-cart tbody').find('#p-' + motor.no_plat);
                let telat = 1; // Hitung keterlambatan pengembalian di sini
                let telat1 = 3; // Hitung keterlambatan pengembalian di sini
                let telat2 = 5; // Hitung keterlambatan pengembalian di sini
                let telat3 = 24; // Hitung keterlambatan pengembalian di sini
                let denda = hitungDenda(telat);
                let denda1 = hitungDenda(telat1);
                let denda2 = hitungDenda(telat2);
                let denda3 = hitungDenda(telat3);

                if (rowExist.length > 0) {
                    let qtyInput = rowExist.find('.qty').eq(0);
                    let qty = parseInt(qtyInput.val().split(' ')[0]);
                    qty += 1;
                    qtyInput.val(qty);
                    rowExist.find('td').eq(3).text(qty + ' hari');
                    rowExist.find('td').eq(4).text((qty * motor.price_per_day));
                } else {
                    let row = '';
                    row += `<tr id='p-${motor.no_plat}'>`;
                    row += `<td>${motor.no_plat}</td>`;
                    row += `<td>${motor.name}</td>`;
                    row += `<td>${motor.price_per_day}</td>`;
                    row += `<input type='hidden' name='price[]' class='price' value="${motor.price_per_day}" />`;
                    row += `<input type='hidden' name='qty[]' class='qty' value="1" />`;
                    row += `<input type='hidden' name='id_motor[]' value="${motor.id}" />`;
                    row += `<td>1 hari</td>`;
                    row += `<td>${motor.price_per_day}</td>`;
                    row += `<input type='hidden' name='denda[]' value='${denda}' />`;
                    row += `<input type='hidden' name='denda1[]' value='${denda1}' />`;
                    row += `<input type='hidden' name='denda2[]' value='${denda2}' />`;
                    row += `<input type='hidden' name='denda3[]' value='${denda3}' />`;
                    row += `<td>${denda}</td>`;
                    row += `<td>${denda1}</td>`;
                    row += `<td>${denda2}</td>`;
                    row += `<td>${denda3}</td>`;
                    row += `</tr>`;
                    $('#table-cart tbody').append(row);
                }
                hitungTotalBelanja();
            }

            function hitungTotalBelanja() {
                let subtotal = 0;
                $.each($('.price'), function (index, obj) {
                    let price_per_hour = $(this).val(); // Ubah menjadi harga per jam
                    let qty = $('.qty').eq(index).val();
                    subtotal += parseInt(price_per_hour) * parseInt(qty); // Hitung subtotal berdasarkan harga per jam dan jumlah jam sewa
                    console.log(price_per_hour, qty);
                });
                let discount = parseInt($('#discount').val());
                let total = subtotal - (subtotal * discount / 100);
                $('#subtotal').val(subtotal);
                $('#total').val(total);
            }

            $('#discount').on('change',function() {
                hitungTotalBelanja();
            })

        });
        function hitungDenda(telat) {
            let denda = 0;
            const denda_1_jam = 5000;
            const denda_3_jam = 10000;
            const denda_5_jam = 15000;
            const denda_24_jam = 40000;

            if (telat >= 1 && telat < 3) {
                denda = denda_1_jam;
            } else if (telat >= 3 && telat < 5) {
                denda = denda_3_jam;
            } else if (telat >= 5 && telat < 24) {
                denda = denda_5_jam;
            } else if (telat >= 24) {
                denda = denda_24_jam;
            }
            return denda;
        }
    </script>
@endpush
