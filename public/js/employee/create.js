$(function () {
    $('#profile').change(function () {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-profile').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
});
