<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="productModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-name" id="productModal">TAMBAH PRODUCT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="nama" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Kategori</label>
                    <select class="form-control" id="id_kategori">
                        @if ($categories->isEmpty())
                            <option value="">Kategori Kosong, Silahkan tambahkan Kategori Terlebih Dahulu</option>
                        @else
                            <option value="" disabled selected>Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_kategori"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Stok</label>
                    <input type="number" class="form-control" id="stok" min="0" max="100000">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-stok"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Harga</label>
                    <input type="number" class="form-control" id="harga" min="1" max="10000000">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('body').on('click', '#btn-create-product', function() {
            $('#modal-create').modal('show');
        });

        function validateStok(input, alertElement) {
            var value = parseFloat(input.val());
            if (value < 0 || value > 100000) {
                alertElement.text('Stok harus diantara 0 hingga 100,000.');
                alertElement.removeClass('d-none');
                input.val(0);
            } else {
                alertElement.addClass('d-none');
            }
        }

        function validateHarga(input, alertElement) {
            var value = parseFloat(input.val());
            if (value < 1 || value > 10000000) {
                alertElement.text('Harga harus diantara Rp.1 hingga Rp.10,000,000.');
                alertElement.removeClass('d-none');
                input.val(1);
            } else {
                alertElement.addClass('d-none');
            }
        }

        $('#stok').on('input', function() {
            validateStok($(this), $('#alert-stok'));
        });

        $('#harga').on('input', function() {
            validateHarga($(this), $('#alert-harga'));
        });

        $('#store').click(function(e) {
            e.preventDefault();

            let nama = $('#nama').val();
            let deskripsi = $('#deskripsi').val();
            let id_kategori = $('#id_kategori').val();
            let stok = $('#stok').val();
            let harga = $('#harga').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/product`,
                type: "POST",
                cache: false,
                data: {
                    "nama": nama,
                    "deskripsi": deskripsi,
                    "id_kategori": id_kategori,
                    "stok": stok,
                    "harga": harga,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    let product = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.nama}</td>
                        <td>${response.data.deskripsi}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-product" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-product" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                    $('#table-products').prepend(product);
                    $('#nama').val('');
                    $('#deskripsi').val('');
                    $('#modal-create').modal('hide');
                },
                error: function(error) {
                    if (error.responseJSON.nama[0]) {
                        $('#alert-nama').removeClass('d-none');
                        $('#alert-nama').addClass('d-block');
                        $('#alert-nama').html(error.responseJSON.nama[0]);
                    }

                    if (error.responseJSON.deskripsi[0]) {
                        $('#alert-deskripsi').removeClass('d-none');
                        $('#alert-deskripsi').addClass('d-block');
                        $('#alert-deskripsi').html(error.responseJSON.deskripsi[0]);
                    }
                }
            });
        });
    });
</script>
