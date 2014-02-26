/**
 * Adds the "active" class to the nav menus
 * This class creates the blue underscore and acts as a visual aid 
 * to know what page you are on
 */
$(document).ready(function() {
    var url = window.location.href.replace(/\/$/, '').replace(window.location.protocol + "//" + window.location.host, '');
    var url_pieces = url.replace(/^\/|\/$/g, '').split(/\//);
    var ending = url_pieces[0];
    
    if (ending == '') {
        $('a[href="/home"]').attr('class', 'active');
    }
    else {
        // Get all the <a> tags
        var nav_links = $('#nav').find('li a');
        
        nav_links.each(function(i, link) {
            if ($(link).attr('href') == ("/" + ending))
                $(link).attr('class', 'active');
        });
    }
});

/**
 * It's only use is on the interested page
 * It generates extra fieldsets depending on how many children the
 * user selects from the drop-down menu
 */
$(document).ready(function() {
	$('#num_children').change(function() {
	    $('.dob').datepicker('destroy');
	    var temp = $('#childForm_1').wrap('<fieldset>').parent();  
	    $('#parentForm').nextAll().remove();
	    var num = $('#num_children').val();
        var interested = $('#interested');
	    for (var i = 1; i <= num; i++) {
	        temp.children().attr('id', 'childForm_' + i);
	        temp.children().children('legend:first').text('Child #' + i);
	        temp.children().children(':nth-child(2)').attr('name', 'child_name_' + i);
	        temp.children().children(':nth-child(3)').attr('name', 'dob_' + i).attr('id', 'dob_' + i);
	        temp.children().children(':nth-child(4)').attr('name', 'gender_' + i);
	        interested.append(temp.html());
	        
	        $('#dob_' + i).datepicker({
		        yearRange: '-20:+0',
		        maxDate: 0,
		        changeMonth: true,
		        changeYear: true,
		        showAnim: 'clip'
	    	});
	    }
	    
	    var submitButton = $(document.createElement('input')).attr('type', 'submit').attr('value', 'Submit');
        interested.append(submitButton);
	    
	});
	$('#dob_1').datepicker({
	    yearRange: '-20:+0',
	    maxDate: 0,
	    changeMonth: true,
	    changeYear: true,
	    showAnim: 'clip'
	});

});

/**
 * Checks if the user entered any input at all before
 * sending data to the server to process it.
 */
$(document).ready(function() {
	$('#login_form').on('submit', function(event) {
		var inputs = $('#login_form :input').not(':submit');
		
		var passed = true;
		inputs.each(function(i, input) {
			var error = $(document.createElement('div')).attr('class', 'error').text('This field was left blank');
			if ($(input).next().text() == error.text())
				$(input).next().remove();
			if ($(input).val() == '') 
			{
				$(input).after(error);
				passed = false;
			}
		});
		
		return passed;
	});
});

/**
 * Gets the version of IE running. If it is not IE or IE 10+ -1 is returned 
 */
function getIEVersion() 
{
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) 
    { 
        var ieversion = new Number(RegExp.$1); // capture x.x portion and store as a number
        return ieversion;
    }
    return -1;
}

$(document).ready(function() {
    if (getIEVersion() != -1 && getIEVersion() < 10)
    {
        var inputs = $('input[type=text], input[type=password]'); 
        inputs.each(function(i, input) {
            $('<br><label>' + $(input).attr('placeholder') + '</label>').insertBefore(input); 
        });
    }      
});
