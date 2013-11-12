<!DOCTYPE html>
<html>
    <head>
        <title>Radford Child Development</title>
        <link rel="stylesheet" type="text/css" href="css/default.css">
        <script type="text/javascript" src="js/switchCSS.js"></script>
        <meta charset="utf-8">
        <meta name="keywords" content="radford, radford childcare, childcare, child care, daycare, radford daycare, radford child development, daycare">
    </head>
    <body>
        <?php if (!isset($_SESSION['user'])) print("<a class=\"right\" href=\"?p=login\">Login/Register</a>"); ?>
        <div id="header">
            <h1>Radford Child Development Inc.</h1>
            <img src="images/banner.jpg">
        </div>
        <div id="wrapper">
            <div class="clear" id="nav">
                <ul>
                    <li><a <?php 
                    	if (!isset($_GET[p]))
						{ 
                    		echo "class=\"active\"";  
						}
						else {
							if ($_GET[p] == "home")
								echo "class=\"active\"";
						}
                    	?> href="?p=home">Home</a></li>
                    <li><a <?php if ($_GET[p] == "donate") echo "class=\"active\"" ?> href="?p=donate">Donate</a></li>
                    <li><a <?php if ($_GET[p] == "articles") echo "class=\"active\"" ?> href="?p=articles">Articles</a></li>
                    <li><a <?php if ($_GET[p] == "about") echo "class=\"active\"" ?> href="?p=about">About Us</a></li>
                </ul>
                <a class="donate" target="_blank"
                   href="https://cfnrv.givebig.org/c/NRV/a/cfnrv-013/">Donate</a>
            </div>
            <div class="clear" id="content">
                <div id="body">
