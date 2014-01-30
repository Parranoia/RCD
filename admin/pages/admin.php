<?php
include_once('include/functions.php');


if (isset($_SESSION['user']))
{
	redirect();
	die();
}
else 
{
	// Check if they are admin	
}

include_once('include/config.php');
include_once('admin/include/header.php');

if (isset($_GET['p']))
{
	$page = 'admin/pages/' . $_GET['p'] . '.php';
	if (file_exists($page))
		include_once($page);
	else
		include_once('admin/pages/notFound.php');
}
else 
	include_once('admin/pages/admin.php');

include_once('admin/include/footer.php');

?>