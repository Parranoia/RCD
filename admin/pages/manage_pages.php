<?php
function deleteDir($dir) {  
    $iterator = new RecursiveDirectoryIterator($dir);  
    foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file) {  
      if ($file->isDir()) {  
         rmdir($file->getPathname());  
      } else {  
         unlink($file->getPathname());  
      }  
    }  
    rmdir($dir);  
}

if (!empty($_POST))
{    
    include_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');

    if (empty($_SESSION['user']))
        die();
    else
        if ($_SESSION['privilege'] === 0)
            die();
        
    if (!empty($_POST['restore_page']))
    {
        $query = 'SELECT position FROM pages ORDER BY position DESC LIMIT 1';
        
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            die();
        }
        $row = $stmt->fetch();
        $position = (int)$row['position'] + 1;
        
        $query = 'SELECT content, custom FROM deleted_pages WHERE name = :name';
        $query_params = array(':name' => $_POST['restore_page']);
        
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);
        }
        catch(PDOException $e)
        {
            die();
        }
        $row = $stmt->fetch();
        
        $query = 'INSERT INTO pages (name, position, content, custom) VALUES (:name, :position, :content, :custom)';
        $query_params = array(':name' => $_POST['restore_page'],
                              ':position' => $position,
                              ':content' => $row['content'],
                              ':custom' => $row['custom']);

        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);
        }
        catch(PDOException $e)
        {
            die();
        }
        
        $query = 'DELETE FROM deleted_pages WHERE name = :name';
        $query_params = array(':name' => $_POST['restore_page']);
        
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);
        }
        catch(PDOException $e)
        {
            die();
        }
    }
        
    if (!empty($_POST['new_page']))
    {
        $query = 'SELECT position FROM pages ORDER BY position DESC LIMIT 1';
        
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            die();
        }
        $row = $stmt->fetch();
        
        $query = 'INSERT INTO pages (name, position, content) VALUES (:name, :position, :content)';
        $query_params = array(':name' => $_POST['new_page'],
                              ':position' => ((int)$row['position']) + 1,
                              ':content' => '<h3>Sample Text<h3>');
        
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);
        }
        catch(PDOException $e)
        {
            die();
        }
    }    
        
    if (!empty($_POST['del_page']))
    {
        $query = 'SELECT content, custom FROM pages WHERE name = :name';
        $query_params = array(':name' => $_POST['del_page']);
        
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);
        }    
        catch(PDOException $e)
        {
            die();
        }
        $row = $stmt->fetch();
        
        $query = 'INSERT INTO deleted_pages (name, content, custom) VALUES (:name, :content, :custom)';
        $query_params = array(':name' => $_POST['del_page'],
                              ':content' => $row['content'],
                              ':custom' => $row['custom']);
         
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);
        }
        catch(PDOException $e)
        {
            die();
        }
        
        $query = 'DELETE FROM pages WHERE name = :name LIMIT 1';
        $query_params = array(':name' => $_POST['del_page']);
        
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute($query_params);
        }
        catch(PDOException $e)
        {
            die();
        }
    }
        
    if (!empty($_POST['update_banner']))
    {
        $source = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/' . $_POST['update_banner'];
        $dest = $_SERVER['DOCUMENT_ROOT'] . '/assets/banner/image.' . pathinfo($source, PATHINFO_EXTENSION);
        
        deleteDir($_SERVER['DOCUMENT_ROOT'] . '/assets/banner');
        mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/banner');
        
        copy($source, $dest);
    }

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
            echo $page;    
    }

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
                <div style="display:inline-block">
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
                    <h3>Update the main banner</h3>
                    <div class="options">
                        <select>
                            <option value="">Choose a new banner</option>
<?php
    $files = scandir($_SERVER['DOCUMENT_ROOT'] . '/assets/images');
    foreach ($files as $file)
        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/assets/images/' . $file)) 
            echo "\t\t\t    <option value=\"$file\">$file</option>\n";
?>
                        </select>
                        <input id="newBanner" type="button" value="Update">
                        <p id="bupdate" style="font-weight: bold; color: green; font-size: 16px; display: none">Banner updated!</p>
                    </div>
                    <h3>Add a page</h3>
                    <div class="options">
                        <input type="text" placeholder="Enter page name" />
                        <input id="newPage" type="button" value="Add Page" />
                    </div>
                    <h3>Delete a page</h3>
                    <div class="options">
                        <select>
                            <option value="">Choose page</option>
<?php foreach ($rows as $row) echo "\t\t\t    <option value=\"" . $row['name'] . "\">" . ucfirst($row['name']) . "</option>\n"; ?>
                        </select>
                        <input id="delPage" type="button" value="Delete Page">
                    </div>
                    <h3>Restore a page</h3>
                    <div class="options">
                        <select>
                            <option value="">Choose page</option>
<?php
$query = 'SELECT name FROM deleted_pages';

try
{
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch(PDOException $e)
{
    die();
}
$del_pages = $stmt->fetchAll();

foreach ($del_pages as $p)
    echo "\t\t\t    <option value=\"" . $p['name'] . "\">" . ucfirst($p['name']) . "</option>\n";
?>
                        </select>
                        <input id="resPage" type="button" value="Restore Page" />
                    </div>
                </div>
                
                <div class="page_content">
                    <textarea name="content"></textarea>
                </div>
                
                <script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
                <script>
                    tinymce.init({
                        selector: 'textarea',
                        width: 600,
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