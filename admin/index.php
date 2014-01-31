<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

/*
 * Commented out while we are testing
if (isset($_SESSION['user']))
{
    redirect();
    die();
}
else 
{
    // Check if they are admin  
}
*/
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/include/header.php');

if (isset($_GET['p']))
{
    $page = $_SERVER['DOCUMENT_ROOT'] . '/admin/pages/' . $_GET['p'] . '.php';
    if (file_exists($page))
        include_once($page);
    else
        include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/pages/notFound.php');
}
else 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/pages/admin.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/include/footer.php');

?>