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
        $page = getPage($_GET['p'], $db);
        if ($page)
            echo $page;
        else
		  include_once($_SERVER['DOCUMENT_ROOT'] . '/pages/notFound.php');
    }
}
else 
	echo printPage('home', $db);

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/footer.php');