<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');

if (isset($_GET['p']))
{
	$page = $_SERVER['DOCUMENT_ROOT'] . '/pages/' . $_GET['p'] . '.php';
	if (file_exists($page))
		include_once($page);
	else
    {
        include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/include/Page.class.php");
        $page = Page::buildPage($_GET['p'], $db);
        if ($page)
            $page->printPage();
        else
		  include_once($_SERVER['DOCUMENT_ROOT'] . '/pages/notFound.php');
    }
}
else 
	include_once($_SERVER['DOCUMENT_ROOT'] . '/pages/home.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/footer.php');