<?php

include_once('include/config.php');
include_once('include/functions.php');
include_once('include/header.php');

if (isset($_GET['p']))
{
	$page = 'pages/' . $_GET['p'] . '.php';
	if (file_exists($page))
		include_once($page);
	else
		include_once('pages/notFound.php');
}
else 
	include_once('pages/home.php');

include_once('include/footer.php');

?>