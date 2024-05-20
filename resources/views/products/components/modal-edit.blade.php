<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT PRODUCT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="product_id">

                <div class="form-group">
                    <label for="nama" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi-edit" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Kategori</label>
                    <select class="form-control" id="kategori_edit">
                        @if ($categories->isEmpty())
                            <option value="">Kategori Kosong, Silahkan tambahkan Kategori Terlebih Dahulu</option>
                        @else
                            <option value="" disabled selected>Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert_kategori_Edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Stok</label>
                    <input type="number" class="form-control" id="stok_edit" min="0" max="100000">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert_stok_edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Harga</label>
                    <input type="number" class="form-control" id="harga_edit" min="1" max="10000000">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert_harga_edit"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="update">UPDATE</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-edit-product', function() {

        let product_id = $(this).data('id');

        //fetch detail post with ajax
        $.ajax({
            url: `/product/${product_id}`,
            type: "GET",
            cache: false,
            success: function(response) {

                //fill data to form
                $('#product_id').val(response.data.id);
                $('#nama-edit').val(response.data.nama);
                $('#deskripsi-edit').val(response.data.deskripsi);
                $('#stok_edit').val(response.data.stok);
                $('#harga_edit').val(response.data.harga);
                $('#kategori_edit').val(response.data.id_kategori);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update post
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let product_id = $('#product_id').val();
        let nama = $('#nama-edit').val();
        let deskripsi = $('#deskripsi-edit').val();
        let stok = $('#stok_edit').val();
        let harga = $('#harga_edit').val();
        let id_kategori = $('#id_kategori').val();
        let token = $("meta[nama='csrf-token']").attr("content");

        //ajax
        $.ajax({

            url: `/product/${product_id}`,
            type: "PUT",
            cache: false,
            data: {
                "nama": nama,
                "deskripsi": deskripsi,
                "stok": stok,
                "harga": harga,
                "id_kategori": id_kategori,
                "_token": token
            },
            success: function(response) {

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                //data post
                let post = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.nama}</td>
                        <td>${response.data.deskripsi}</td>
                        <td>${response.data.id_kategori}</td>
                        <td>${response.data.stok}</td>
                        <td>${response.data.harga}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;

                //append to post data
                $(`#index_${response.data.id}`).replaceWith(post);

                //close modal
                $('#modal-edit').modal('hide');


            },
            error: function(error) {

                if (error.responseJSON.nama[0]) {

                    //show alert
                    $('#alert-nama-edit').removeClass('d-none');
                    $('#alert-nama-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-nama-edit').html(error.responseJSON.nama[0]);
                }

                if (error.responseJSON.deskripsi[0]) {

                    //show alert
                    $('#alert-deskripsi-edit').removeClass('d-none');
                    $('#alert-deskripsi-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-deskripsi-edit').html(error.responseJSON.deskripsi[0]);
                }
            }
        });
    });
</script>
