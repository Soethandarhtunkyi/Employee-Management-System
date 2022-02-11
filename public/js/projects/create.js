$(function () {
    $('#employees').DataTable();
    var employees = [];
    $("#employees").on("click", ".sync", function () {
        var id = $(this).data('id');
        if (employees.includes(id)) {
            employees = employees.filter(employee => employee != id);
            $(this).html('Add');
        } else {
            employees.push(id);
            $(this).html('Remove');
            $(this).css('background-color', 'light-red');
        }
    });
    $('#submit-post').on('click', function (e) {
        $.ajax({
            url: '/project/store',
            method: 'POST',
            data: {
                'name': $('#name').val(),
                'link': $('#link').val(),
                'employees': employees
            },
            success: function (data) {
                if (data.result) {
                    location.href = "/project";
                }
            },
            error: function (err) {
                if (err.status === 422) {
                    $('.seprator').append(
                        `<div class="alert-errmsg">
                            <strong>Whoops! Something went wrong!</strong>
                            <br><br>
                            <ul class="error">
                            </ul>
                        </div>`
                    );
                    $.each(err.responseJSON.errors, function (key, value) {
                        $('.error').append(
                            `<li class="errline-msg">${value[0]}</li>`
                        );
                    });
                    $('div.alert-errmsg').delay(10000).slideUp(300);
                } else {
                    $('.seprator').append(
                        `<div class="alert-errmsg">
                            <strong>Whoops! Something went wrong!</strong>
                            <br><br>
                            <ul class="error">
                                <li class="errline-msg">Unknown Error Occured.</li>
                            </ul>
                        </div>`
                    );
                }
            }
        });
    });
});
