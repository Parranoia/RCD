$(document).ready(function() {
    $('input, select').change(function() {
        $('input[type=submit]').removeAttr('disabled');
    });
});
