<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/include/Page.class.php");

if (isset($_GET['p']))
{
	$page = $_SERVER['DOCUMENT_ROOT'] . '/pages/' . $_GET['p'] . '.php';
	if (file_exists($page))
		include_once($page);
	else
    {
        $page = Page::buildPage($_GET['p'], $db);
        if ($page)
            $page->printPage();
        else
		  include_once($_SERVER['DOCUMENT_ROOT'] . '/pages/notFound.php');
    }
}
else 
	Page::buildPage('home', $db)->printPage();

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/footer.php');