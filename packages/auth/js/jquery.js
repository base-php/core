$(document).ready(function () {
    $('.confirm-delete').click(function (event) {
        event.preventDefault();

        title = $('#confirm_delete_text').val();
        confirmButtonText = $('#confirm_delete_accept').val();
        cancelButtonText = $('#confirm_delete_cancel').val();

        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmButtonText,
            confirmButtonColor: 'black',
            cancelButtonText: cancelButtonText
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = element.href;
            }
        });
    });

    $('.remove-photo').click(function () {
        url = $('#photo-url').val();
        $('#photo-preview').attr('src', url);
    });

    $('.preview').change(function () {
        input = document.getElementById('photo');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (event) {
                document.getElementById('photo-preview').setAttribute('src', event.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    });
});
