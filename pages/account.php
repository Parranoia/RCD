<?php

if (!isset($_GET['action']))
{
	// Should display account information page
	// Will be completed in iteration 1
}
else
{
	$action = $_GET['action'];
	switch($action)
	{
		case "verify": include_once('pages/verify.php'); break;
		case "forgot_password": include_once('pages/forgot_password.php'); break;
        case "recover_password": include_once('pages/recover_password.php'); break;
		default: include_once('pages/notFound.php'); break;
	}
}

?>