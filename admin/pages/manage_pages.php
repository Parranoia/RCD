<?php
if (!empty($_POST))
{
    include_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
    
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
    die();
}

$query = 'SELECT name, custom FROM pages ORDER BY position ASC';
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
$pages_current = array();
$pages_new = array();

?>
                <h3>Reposition the order of the pages, or click on them to edit them</h3>
                <div class="page_list">
<?php
$itr = 0;
foreach ($rows as $row)
{
    $pages_current[$row['name']] = $itr++;
    echo "\t\t    <div class=\"page_info\">\n";
    echo "\t\t\t<p>". ucfirst($row['name']) . "</p>\n";
    echo "\t\t\t<p>\n";
    echo "\t\t\t    <i class=\"fa fa-arrow-up fa-fw fa-lg\"></i>\n";
    echo "\t\t\t    <i class=\"fa fa-arrow-down fa-fw fa-lg\"></i>\n";
    echo "\t\t\t</p>\n";
    echo "\t\t    </div>\n";    
}
$pages_new = $pages_current;
?>
                </div>
                <script>
                    var animating = false;
                    
                    window.setInterval(function() {
                        
                    }, 3000);
                    
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