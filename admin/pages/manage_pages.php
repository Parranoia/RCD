<?php
if (!empty($_POST))
{    
    include_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');

    if (empty($_SESSION['user']))
        die();
    else
        if ($_SESSION['privilege'] === 0)
            die();

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
                <script type="text/javascript" src="/admin/js/manage_pages.js"></script>
                <script>
                    tinymce.init({
                        selector: 'textarea',
                        height: 250,
                        resize: 'both',
                        content_css: '/css/default.css',
                        browser_spellcheck : true,
                        gecko_spellcheck: true,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen textcolor',
                            'insertdatetime media table contextmenu paste filemanager'
                        ],
                        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor'
                    });
                </script>