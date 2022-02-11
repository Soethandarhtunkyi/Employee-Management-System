$(function () {
    $('#attendances').DataTable();

    $(".card-submit").heightLine({
        fontSizeCheck: true
    });

    $('#dates').daterangepicker({
        opens: 'left'
    }, function (start, end, label) {
        $('#start').val(start.format('YYYY-MM-DD'));
        $('#end').val(end.format('YYYY-MM-DD'));
    });

    $('#leave').on('change', function () {
        $('input[type=radio]').prop('disabled', this.checked);
    });
});
