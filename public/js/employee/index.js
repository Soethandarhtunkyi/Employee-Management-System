$(function () {
    $('.delete-btn').on('click', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure want to delete?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $(`#del-form${id}`).submit();
            }
        });
    });
});
