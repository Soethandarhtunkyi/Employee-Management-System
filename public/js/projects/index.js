$(function () {
    $('#projects').DataTable({
        "aaSorting": []
    });
    $('#projects').on('click', '.del-btn', function () {
        var id = $(this).data('id');
        var node = $(this).parent().parent();
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
                $.ajax({
                    url: '/project/' + id,
                    method: 'DELETE',
                    success: function (data) {
                        if (data.result) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Project deleted successfully.'
                            });
                            node.remove();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    }
                });
            }
        });
    });
});
