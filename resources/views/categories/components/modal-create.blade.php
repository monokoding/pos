<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-name" id="exampleModalLabel">TAMBAH CATEGORY</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" class="form-control" id="name">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
                </div>


                <div class="form-group">
                    <label class="control-label">Description</label>
                    <textarea class="form-control" id="description" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-description"></div>
                </div>

                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create category event
    $('body').on('click', '#btn-create-category', function() {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create category
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let name = $('#name').val();
        let description = $('#description').val();
        let token = $("meta[name='csrf-token']").attr("content");

        //ajax
        $.ajax({
            url: `/category`,
            type: "POST",
            cache: false,
            data: {
                "name": name,
                "description": description,
                "_token": token
            },
            success: function(response) {
                //show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 3000
                });

                //data category
                let category = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.name}</td>
                        <td>${response.data.description}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-category" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-category" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;

                //append to table
                $('#table-categories').prepend(category);

                //clear form
                $('#name').val('');
                $('#description').val('');

                //close modal
                $('#modal-create').modal('hide');


            },
            error: function(error) {

                if (error.responseJSON.name[0]) {

                    //show alert
                    $('#alert-name').removeClass('d-none');
                    $('#alert-name').addClass('d-block');

                    //add message to alert
                    $('#alert-name').html(error.responseJSON.name[0]);
                }

                if (error.responseJSON.description[0]) {

                    //show alert
                    $('#alert-description').removeClass('d-none');
                    $('#alert-description').addClass('d-block');

                    //add message to alert
                    $('#alert-description').html(error.responseJSON.description[0]);
                }

            }

        });

    });
</script>
