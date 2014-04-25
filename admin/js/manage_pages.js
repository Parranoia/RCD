function managePageAjax(data) {
    return $.ajax({ 
        url: '/admin/pages/manage_pages.php',
        type: 'POST',
        data: data 
    });
}


var submitting = false;

$('.page_info p:first-child').on('click', function() {
    if (submitting)
        return;
        
    var page = $(this);
    var editor = $('.page_content');
    if (page.hasClass('active'))
    {
        page.toggleClass('active');
        page.parent().toggleClass('active');
        // Get rid of textarea and submit data
        var data = $.param({ page: page.html().toLowerCase(), content: tinyMCE.activeEditor.getContent() });
        submitting = true;
        managePageAjax(data).done(function() { 
            submitting = false;
            editor.animate({ opacity: 0 }, 600); 
            });
    }
    else
    {
        // Save any other editor that might have been open
        var active = $('.active p');
        if (active.length)
        {
            var data = $.param({ page: active.html().toLowerCase(), content: tinyMCE.activeEditor.getContent() });
            submitting = true;
            managePageAjax(data).done(function() { 
                submitting = false;
             });
        }
        
        $('.active').removeClass('active');
        var data = $.param({ request_page: page.html().toLowerCase() });
        submitting = true;
        
        managePageAjax(data).done(function(response) { 
            submitting = false;
            if (response.length) {
                tinyMCE.activeEditor.setContent(response);
                editor.animate({ opacity: 1 }, 600);    
                page.toggleClass('active');
                page.parent().toggleClass('active');
            } else {
                editor.animate({ opacity: 0 }, 600);
                alert('This is a custom page and cannot be edited');
            }
        });
    }
});

var animating = false;
                    
$('.page_info i').on('click', function() {
    if (animating)
        return;
        
    var container = $(this).parents('.page_info');
    var distance = container.outerHeight();
    var thisPage = $(this).parent().prev().html().toLowerCase();
    // Check if this div needs to move up or down
    var up = $(this).hasClass('fa-arrow-up');

    var other = up ? $(container).prev() : $(container).next();
    if (other.length == 0)
        return;
        
    var otherPage = $($(other).children()[0]).html().toLowerCase();
    
    animating = true;
    $.when(container.animate({
        top: up ? -distance - 5 : distance + 5
    }, 600),
    other.animate({
        top: up ? distance + 5 : -distance - 5
    }, 600)).done(function() {
        other.css('top', '0px');
        container.css('top', '0px');
        up ? container.insertBefore(other) : container.insertAfter(other);
        animating = false;
    });
    
    var data;
    if (up)
        data = $.param({ this_page: thisPage, prev_page: otherPage });
    else
        data = $.param({ this_page: thisPage, next_page: otherPage });
    
    managePageAjax(data);    
});

// Updating the header image
$(document).ready(function() {
    $('#newbanner').click(function() {
        var path = $('#newBanner').siblings('select').val();
        if (path) {
            data = $.param({ update_banner: path });
            
            managePageAjax(data);
            $('#bupdate').show('slow');
            setTimeout(function() { $('#bupdate').hide('slow'); }, 2000);
        }
    });
});

// Delete page
$(document).ready(function() {
    $('#delPage').click(function() {
        // Confirm with the user to delete this page
        if (!window.confirm("Are you sure you want to delete this page?\nNote: Pages are not permanently deleted. It is possible to restore them"))
            return;
            
        var page = $('#delPage').siblings('select').val();
        if (page) {
            data = $.param({ del_page: page });
            
            managePageAjax(data).done(function() {
                location.reload(true);
            });
        } 
    });
});

// Create new page
$(document).ready(function() {
    $('#newPage').click(function() {
        // Delete any error message if one exists
        if ($('#newPage').next())
            $('#newPage').next().remove();
            
        var page = $('#newPage').siblings('input[type=text]').val();
        if (!page.match(/^[a-z]{1,30}$/))
            $('#newPage').after('<div class="error">Page name may only contain lowercase letters</div>');
        else {
            data = $.param({ new_page: page });
            
            managePageAjax(data).done(function() {
                location.reload(true);
            });
        }
    });
});

// Restore deleted pages
$(document).ready(function() {
    $('#resPage').click(function() {
        var page = $('#resPage').siblings('select').val();

        if (page) {
            data = $.param({ restore_page: page });
            
            managePageAjax(data).done(function() {
                location.reload(true);
            });
        }     
    });
});
