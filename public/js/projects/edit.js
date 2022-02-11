$(function () {
    var id = $('#prj-id').val();
    function getUpdateMembers() {
        $.ajax({
            url: '/project/' + id + '/members',
            method: 'GET',
            success: function (data) {
                if (data.result) {
                    $.each(data.data.members, function (key, value) {
                        $('#tmembers').append(
                            `<tr>
                                <td>${value}</td>
                                <td><a href="javascript:void(0)" data-id="${key}" class="button-4 sync">Remove</a></td>
                            </tr>`
                        );
                    });
                    $.each(data.data.nonMembers, function (key, value) {
                        $('#tnon-members').append(
                            `<tr>
                                <td>${value}</td>
                                <td><a href="javascript:void(0)" data-id="${key}" class="button-4 sync">Add</a></td>
                            </tr>`
                        );
                    });
                    $(document).find('#members, #non-members').DataTable();
                }
            }
        });
    }
    getUpdateMembers();
    $("#members, #non-members").on("click", ".sync", function () {
        var memId = $(this).data('id');
        $.ajax({
            url: '/project/' + id + '/' + memId + '/membertoogle',
            method: 'GET',
            success: function (data) {
                if (data.result) {
                    $('#tmembers, #tnon-members').children().remove();
                    getUpdateMembers();
                }
            }
        });
    });
});
