<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

if (isset($_GET['p']))
{
    $response = pageExists($_GET['p'], $db);
    if (!$response)
    {
        http_response_code(404);
        die();
    }
    else 
    {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');
        if (substr($response, strlen($response) - 4, 4) === '.php')
            include_once($response);
        else
            echo $response;
    }
}
else 
{
    include_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');
    echo getPage('home', $db);
}    
function pageExists($p, $db)
{
	$page = $_SERVER['DOCUMENT_ROOT'] . '/pages/' . $p . '.php';
	if (file_exists($page))
		return $page;
	else
    {
        $page = getPage($p, $db);
        if ($page)
            return $page;
        else
            return false;
    }
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/footer.php');