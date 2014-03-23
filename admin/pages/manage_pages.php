<?php
$query = 'SELECT position, name, custom FROM pages ORDER BY position ASC';
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
    echo "\t\t\t<p>". ucfirst($row['name']) . "</p>\n";
    echo "\t\t\t<p>\n";
    echo "\t\t\t    <i class=\"fa fa-arrow-up fa-fw fa-lg\"></i>\n";
    echo "\t\t\t    <i class=\"fa fa-arrow-down fa-fw fa-lg\"></i>\n";
    echo "\t\t\t</p>\n";
    echo "\t\t    </div>\n";    
}
?>
                </div>
                <script>
                    var animating = false;
                    
                    $('.page_info i').on('click', function() {
                        if (animating)
                            return;
                            
                        var container = $(this).parents('.page_info');
                        var distance = container.outerHeight();
                        
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
                            
                            console.log("moved up");
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
                            
                            console.log("moved down");
                        }
                        
                    });
                </script>