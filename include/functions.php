<?php
function redirect($url='', $delay=0)
{
    print("<script>setTimeout(function(){ window.location = \"http://" . $_SERVER['SERVER_NAME'] . $url . "\"}, " . $delay . ');</script>');
}

function get_privilege($num)
{
    if ($num === 0)
        return "User";
    else if ($num === 1)
        return "Admin";
    else if ($num === 2)
        return "Super Admin";
    else 
        return "Invalid";
}

function getPage($name, $db)
{
    $query = 'SELECT content FROM pages WHERE name = :name AND custom = 0';
    $query_params = array(':name' => $name);
    
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute($query_params);
    }
    catch (PDOException $e)
    {
        die();
    }
    $row = $stmt->fetch();
    if (!$row)
        return null;
    
    return $row['content'];
}
