<?php

include_once('include/config.php');
include_once('include/header.php');

if (isset($_GET['p']))
{
	switch($_GET['p'])
	{
		case "home": include_once('pages/home.php'); break;
		case "about": include_once('pages/about.php'); break;
		case "donate": include_once('pages/donate.php'); break;
		case "articles": include_once('pages/articles.php'); break;
		case "register": include_once('pages/register.php'); break;
		case "login": include_once('pages/login.php'); break;
		case "logout": include_once('pages/logout.php'); break;
        case "verify": include_once('pages/verify.php'); break;
		default: include_once('pages/notFound.php'); break;
	}
}
else 
	include_once('pages/home.php');

include_once('include/footer.php');

?>