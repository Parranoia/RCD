<?php
if (!empty($_POST))
{
    include_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');

    if (!empty($_POST['content']))
    {
        $query = 'UPDATE pages SET content = :content WHERE name = :name';
        $query_params = array(':content' => $_POST['content'],
                              ':name' => $_POST['page']);
                              
        echo $_POST['content'];
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);
        }
        catch (PDOException $e)
        {
            die();
        }
    }

    if (!empty($_POST['request_page']))
    {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
        
        $page = getPage($_POST['request_page'], $db);
        if ($page)
            echo $page;    }

    if (!empty($_POST['this_page']))
    {    
        $this_page = $_POST['this_page'];
        if (!empty($_POST['prev_page']))
        {
            $prev_page = $_POST['prev_page']; 
            $query = 'UPDATE pages SET position = position + 1000 WHERE name = :name; UPDATE pages SET position = position + 1000 WHERE name = :prev_name';
            $query_params = array(':name' => $this_page,
                                  ':prev_name' => $prev_page);
                                  
            try
            {
                $stmt = $db->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $e)
            {
                die();
            }
            
            $query = 'UPDATE pages SET position = position - 1000 - 1 WHERE name = :name; UPDATE pages SET position = position - 1000 + 1 WHERE name = :prev_name';
            
            try
            {
                $stmt = $db->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $e)
            {
                die();
            }
        }
        else 
        {
            $next_page = $_POST['next_page'];
            $query = 'UPDATE pages SET position = position + 1000 WHERE name = :name; UPDATE pages SET position = position + 1000 WHERE name = :next_name';
            $query_params = array(':name' => $this_page,
                                  ':next_name' => $next_page);
                                  
            try
            {
                $stmt = $db->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $e)
            {
                die();
            }
            
            $query = 'UPDATE pages SET position = position - 1000 + 1 WHERE name = :name; UPDATE pages SET position = position - 1000 - 1 WHERE name = :next_name';
            
            try
            {
                $stmt = $db->prepare($query);
                $stmt->execute($query_params);
            }
            catch (PDOException $e)
            {
                die();
            }
        }
    }        
    die();
}

$query = 'SELECT position, name FROM pages ORDER BY position ASC';
try
{
    $stmt = $db->prepare($query);
    $stmt->execute();   
}
catch (PDOException $e)
{
    die();
}

$rows = $stmt->fetchAll();

?>
                <h3>Reposition the order of the pages, or click on them to edit them</h3>
                <div class="page_list">
<?php
foreach ($rows as $row)
{
    echo "\t\t    <div class=\"page_info\">\n";
    echo "\t\t\t<p>" . ucfirst($row['name']) . "</p>\n";
    echo "\t\t\t<p>\n";
    echo "\t\t\t    <i class=\"fa fa-arrow-up fa-fw fa-lg\"></i>\n";
    echo "\t\t\t    <i class=\"fa fa-arrow-down fa-fw fa-lg\"></i>\n";
    echo "\t\t\t</p>\n";
    echo "\t\t    </div>\n";    
}
?>
                </div>
                <div class="page_content">
                    <textarea name="content"></textarea>
                </div>
                <script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
                <script>
                    tinymce.init({
                        selector: 'textarea',
                        height: 250,
                        resize: 'both',
                        content_css: '/css/default.css',
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table contextmenu paste moxiemanager'
                        ],
                        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
                    });
                
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
                            $.ajax({
                                url: '/admin/pages/manage_pages.php',
                                type: 'POST',
                                data: data,
                                
                                success: function(response) {
                                    submitting = false;
                                    editor.animate({ opacity: 0 }, 600);
                                }
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
                                $.ajax({
                                    url: '/admin/pages/manage_pages.php',
                                    type: 'POST',
                                    data: data,
                                    
                                    success: function() {
                                        submitting = false;
                                    }
                                });
                            }
                            $('.active').removeClass('active');
                            var data = $.param({ request_page: page.html().toLowerCase() });submitting = true;
                            $.ajax({
                                url: '/admin/pages/manage_pages.php',
                                type: 'POST',
                                data: data,
                                
                                success: function(response) {
                                    submitting = false;
                                    if (response.length) {
                                        tinyMCE.activeEditor.setContent(response);
                                        editor.animate({ opacity: 1 }, 600);
                                        page.toggleClass('active');
                                        page.parent().toggleClass('active');
                                    }
                                    else {
                                        editor.animate({ opacity: 0 }, 600);
                                        alert('This is a custom page and cannot be edited');
                                    }
                                }
                            })
                        }
                    });
                    
                    var animating = false;
                    
                    $('.page_info i').on('click', function() {
                        if (animating)
                            return;
                            
                        var container = $(this).parents('.page_info');
                        var distance = container.outerHeight();
                        
                        var data;
                        
                        // Check if this div needs to go up or down
                        if ($(this).hasClass('fa-arrow-up'))
                        {
                            var prev = $(container).prev();
                            if (prev.length == 0)
                                return;
                            
                            animating = true;
                            $.when(container.animate({
                                top: -distance - 5
                            }, 600),
                            prev.animate({
                                top: distance + 5
                            }, 600)).done(function() {
                                prev.css('top', '0px');
                                container.css('top', '0px');
                                container.insertBefore(prev);
                                animating = false; 
                            });
                            var thisPage = $(this).parent().prev().html().toLowerCase();
                            var prevPage = $($(prev).children()[0]).html().toLowerCase();
                            
                            data = "this_page=" + thisPage + "&prev_page=" + prevPage;
                        }
                        else
                        {
                            var next= $(container).next();
                            if (next.length == 0)
                                return;
                            
                            animating = true;
                            $.when(container.animate({
                                top: distance + 5
                            }, 600),
                            next.animate({
                                top: -distance - 5
                            }, 600)).done(function() {
                                next.css('top', '0px');
                                container.css('top', '0px');
                                container.insertAfter(next);
                                animating = false; 
                            });
                            var thisPage = $(this).parent().prev().html().toLowerCase();
                            var nextPage = $($(next).children()[0]).html().toLowerCase();
                            
                            data = "this_page=" + thisPage + "&next_page=" + nextPage;
                        }
                        
                        $.ajax({
                                url: "/admin/pages/manage_pages.php",
                                type: "POST",
                                data: data,
                        });
                        
                    });
                </script>