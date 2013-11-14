<?php

	if (!isset($_SESSION['user']) || empty($_SESSION['user']))
    {
        header("Location: http://" . $_SERVER['SERVER_NAME']);
        die();
    }

    unset($_SESSION['user']);
    
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    die();
	
?>