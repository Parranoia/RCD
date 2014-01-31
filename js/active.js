$(document).ready(function() {
    var url = window.location.href.replace(/\/$/, '').replace(window.location.protocol + "//" + window.location.host, '');
    var url_pieces = url.replace(/^\/|\/$/g, '').split(/\//);
    var ending = url_pieces[0];
    
    if (ending == '') {
        $('a[href="/home"]').attr('class', 'active');
    }
    else {
        // Get all the <a> tags
        var nav_links = $('#nav li a');
        
        nav_links.each(function(i, link) {
            if ($(link).attr('href') == ("/" + ending))
                $(link).attr('class', 'active');
        });
    }
});