// add or remove new div for add new photo =>> for Edit || Create
$(document).ready(function() {
    let photoIndex = 0;

    $('#add-photo').on('click', function() {
        const photoDiv = $('<div></div>').addClass('photo mb-3');

        const photoNameDiv = $('<div></div>').addClass('form-group');
        const photoNameLabel = $('<label></label>').attr('for', `photos[${photoIndex}][name]`).text('Photo Name');
        const photoNameInput = $('<input>').attr({
            type: 'text',
            name: `photos[${photoIndex}][name]`
        }).addClass('form-control').prop('required', true);
        photoNameDiv.append(photoNameLabel).append(photoNameInput);

        const photoFileDiv = $('<div></div>').addClass('form-group');
        const photoFileLabel = $('<label></label>').attr('for', `photos[${photoIndex}][file]`).text('Upload Photo');
        const photoFileInput = $('<input>').attr({
            type: 'file',
            name: `photos[${photoIndex}][file]`
        }).addClass('form-control').prop('required', true);
        photoFileDiv.append(photoFileLabel).append(photoFileInput);

        const removeButton = $('<button></button>').attr('type', 'button').addClass('btn btn-danger mt-2').text('Remove');
        removeButton.on('click', function() {
            photoDiv.remove();
        });

        photoDiv.append(photoNameDiv).append(photoFileDiv).append(removeButton);

        $('#photos').append(photoDiv);

        photoIndex++;
    });


    // delete album modal

    $('.delete-album').on('click', function() {

        let album_id = $(this).data('id');

        $.ajax({
            url: '/check-count-pictures/' + album_id,
            method: 'GET',
            success: function(data) {
                if (data.picturesCount > 0){
                    $('#exampleModalCenter').modal('show');
                    $('.album_id').val(album_id);

                }else {
                    $.ajax({
                        url: '/albums/' + album_id,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            action: 'delete_album'
                        },
                        success: function(data) {
                            // Handle success, maybe redirect to albums list or show a success message
                            window.location.href = '/albums';
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error deleting album:', textStatus, errorThrown);
                        }
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data:', textStatus, errorThrown);
            }
        });

    });// end delete album button
    $('.close-modal').on('click', function() {
        $('#exampleModalCenter').modal('hide');
    });

    $('.delete-album-w-or-t-picture').on('click', function() {

        let album_id =  $('.album_id').val();
        let selectedAction = $('input[name="type"]:checked').val();
        const target_album = $('.target_album').val();
        if (target_album == null){
            selectedAction = "delete";
        }
        $.ajax({
            url: '/albums/' + album_id,
            method: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content'),
                type: selectedAction,
                target_album:target_album
            },
            success: function(data) {
                // Handle success, maybe redirect to albums list or show a success message
                window.location.href = '/albums';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error deleting album:', textStatus, errorThrown);
            }
        });
        $('#exampleModalCenter').modal('hide');
    });




    // Listen for changes on the radio buttons and make an AJAX request when one is checked
    $('input[name="type"]').on('change', function() {
        const selectedValue = $(this).val();
        let album_id =  $('.album_id').val();
        if (selectedValue === 'transfer') {
            $('#selectAlbumContainer').show();
            $.ajax({
                url: '/get/albums/all/'+ album_id,
                method: 'GET',
                success: function(data) {
                    const selectBox = $('#target_album');
                    selectBox.empty();
                    data.forEach(function(album) {
                        selectBox.append('<option value="' + album.id + '">' + album.name + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching albums:', textStatus, errorThrown);
                }
            });
        } else {
            $('#selectAlbumContainer').hide();
        }
    });



});
