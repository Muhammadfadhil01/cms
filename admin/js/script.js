//bulk option
$(document).ready(function () {
    $('#selectAllboxes').click(function (event) {
        if (this.checked) {
            $('.checkboxes').prop('checked', true);
        } else {
            $('.checkboxes').prop('checked', false);
        }
    });
});


