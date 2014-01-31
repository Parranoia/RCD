$(document).ready(function() {
    $('#num_children').change(function() {
        $('.dob').datepicker("destroy");
        var temp = $('#childForm_1').wrap('<fieldset>').parent();  
        $('#parentForm').nextAll().remove();
        var num = $('#num_children').val();
        for (var i = 1; i <= num; i++) {
            temp.children().attr('id', 'childForm_' + i);
            temp.children().children('legend:first').text('Child #' + i);
            temp.children().children(':nth-child(2)').attr('name', 'child_name_' + i);
            temp.children().children(':nth-child(3)').attr('name', 'dob_' + i);
            temp.children().children(':nth-child(4)').attr('name', 'gender_' + i);
            $('#interested').append(temp.html());
        }
        $('.dob').datepicker({
            yearRange: '-20:+0',
            maxDate: 0,
            changeMonth: true,
            changeYear: true,
            showAnim: 'clip'
        });
    });
    $('.dob').datepicker({
        yearRange: '-20:+0',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        showAnim: 'clip'
    });
});