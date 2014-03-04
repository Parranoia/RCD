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
