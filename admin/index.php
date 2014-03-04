<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');

if (!isset($_SESSION['user']))
{
    redirect();
    die();
}
else 
{
    if ($_SESSION['user']['privilege'] === 0)
    {
        redirect();
        die();
    }
}

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
    include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/pages/home.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/include/footer.php');
