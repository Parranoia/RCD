<?php
function redirect($url='', $delay=0)
{
    print("<script>setTimeout(function(){ window.location = \"http://" . $_SERVER['SERVER_NAME'] . $url . "\"}, " . $delay . ');</script>');
}
?>