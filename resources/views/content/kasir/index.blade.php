@extends('layout.main')
@section('judul','Aplikasi Kasir')
@section('content')

    <div class="row">
        <div class="col-12">
            <input type="text" id="input-barcode" name="barcode"
                   class="form-control" placeholder="Scan Barcode"/>
        </div>
    </div>
    <form method="post" action="{{url('/app/insert')}}">
        <div class="row">
            @csrf
            <div class="col-8 mt-3">
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="table-cart">
                            <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Nama Produk</th>
                                <th>@</th>
                                <th>Qty</th>
                                <th>SubTotal</th>
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
                                    <label for="">Subtotal</label>
                                    <input type="text" readonly name="subtotal" id="subtotal" 
                                        class="form-control text-right">
                                </td>
                            </tr>
                            </tr>
                                <td >
                                    <label for="">Discount (%)</label>
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
                            barcode: $(this).val()
                        },
                        success: function (data) {
                            addProductToTable(data);
                            toastr.success('Barang Berhasil masuk ke keranjang belanja', 'Berhasil');
                            $('#input-barcode').val('');

                        },
                        error: function () {
                            toastr.error('Barang yang dicari tidak ditemukan', 'Error');
                            $('#input-barcode').val('');
                        }
                    })
                }
            });

            function addProductToTable(product) {
                let rowExist = $('#table-cart tbody').find('#p-' + product.barcode);
                if (rowExist.length > 0) {
                    //barcode sudah ada
                    let qty = parseInt(rowExist.find('.qty').eq(0).val());
                    qty += 1;
                    rowExist.find('.qty').eq(0).val(qty);
                    rowExist.find('td').eq(3).text(qty);
                    rowExist.find('td').eq(4).text((qty * product.price));
                } else {
                    let row = '';
                    row += `<tr id='p-${product.barcode}'>`;
                    row += `<td>${product.barcode}</td>`;
                    row += `<td>${product.name}</td>`;
                    row += `<td>${product.price}</td>`;
                    row += `<input type='hidden' name='price[]' class='price' value="${product.price}" />`;
                    row += `<input type='hidden' name='qty[]' class='qty' value="1" />`;
                    row += `<input type='hidden' name='id_product[]' value="${product.id}" />`;
                    row += `<td>1</td>`;
                    row += `<td>${product.price}</td>`;
                    row += `</tr>`;
                    $('#table-cart tbody').append(row);
                }
                hitungTotalBelanja();
            }

            function hitungTotalBelanja() {
                let subtotal = 0;
                $.each($('.price'), function (index, obj) {
                    let price = $(this).val();
                    let qty = $('.qty').eq(index).val();
                    subtotal += parseInt(price) * parseInt(qty);
                    console.log(price, qty);
                });
                let discount = parseInt(('#discount').val());
                let total = subtotal - (subtotal * discount / 100);
                $('#subtotal').val(subtotal);
                $('#total').val(total);
            }
            $('#discount').on('change',function() {
                hitungTotalBelanja();
            })
        });
    </script>
@endpush
