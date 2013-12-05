<?php

if (!isset($_GET['action']))
{
	// Should display account information page
	// Will be completed in iteration 1
}
else
{
	$page = 'pages/' . $_GET['action'] . '.php';
	if (file_exists($page))
		include_once($page);
	else
		include_once('pages/notFound.php');
}

?>