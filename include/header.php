<!DOCTYPE html>
<html>
    <head>
        <title>Radford Child Development</title>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="/css/default.css">
        <script type="text/javascript" src="/js/switchCSS.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <meta charset="utf-8">
        <meta name="keywords" content="radford, radford childcare, childcare, child care, daycare, radford daycare, radford child development, daycare">
    </head>
    <body>
        <?php 
        	if (!isset($_SESSION['user']))
    			print("<a class=\"right\" href=\"/login\">Login/Register</a>\n");
			else {
				print("<a class=\"right\" href=\"/logout\">" . "Logout (" . $_SESSION['user']['username'] . ")</a>\n");
			}
		?>
        <div id="header">
            <h1>Radford Child Development Inc.</h1>
            <img src="/images/banner.jpg">
        </div>
        <div id="wrapper">
            <div class="clear" id="nav">
                <ul>
                    <li><a <?php 
                    	if (!isset($_GET['p']))
                    		echo "class=\"active\"";
						else if ($_GET['p'] == "home")
                            echo "class=\"active\"";
                    	?> href="/home">Home</a></li>
                    <li><a <?php if (isset($_GET['p']) && $_GET['p'] == "donate") echo "class=\"active\""?> href="/donate">Donate</a></li>
                    <li><a <?php if (isset($_GET['p']) && $_GET['p'] == "articles") echo "class=\"active\""?> href="/articles">Articles</a></li>
                    <li><a <?php if (isset($_GET['p']) && $_GET['p'] == "about") echo "class=\"active\""?> href="/about">About Us</a></li>
                </ul>
                <a class="donate" target="_blank"
                   href="https://cfnrv.givebig.org/c/NRV/a/cfnrv-013/">Donate</a>
            </div>
            <div class="clear" id="content">
                <div id="body">
