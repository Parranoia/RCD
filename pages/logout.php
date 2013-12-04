<?php

	if (!isset($_SESSION['user']) || empty($_SESSION['user']))
    {
        redirect();
        die();
    }

    unset($_SESSION['user']);
    
    redirect();
    die();
	
?>