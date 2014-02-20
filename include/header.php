<!DOCTYPE html>
<html>
    <head>
        <title>Radford Child Development</title>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="/css/default.css">
        <script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <meta charset="utf-8">
        <meta name="keywords" content="radford, radford childcare, childcare, child care, daycare, radford daycare, radford child development, daycare">
        
        <script type="text/javascript" src="/js/main.js"></script>
    </head>
    <body>
        <?php 
        	if (isset($_SESSION['user']))
				print("<a class=\"right\" href=\"/logout\">" . "Logout (" . $_SESSION['user']['username'] . ")</a>\n");
		?>
        <div id="header">
            <h1>Radford Child Development Inc.</h1>
            <img src="/images/banner.jpg">
        </div>
        <div id="wrapper">
            <div class="clear" id="nav">
                <ul>
                    <li><a href="/home">Home</a></li>
                    <li><a href="/donate">Donate</a></li>
                    <li><a href="/articles">Articles</a></li>
                    <li><a href="/about">About Us</a></li>
                    <?php if (!isset($_SESSION['user'])) echo "<li><a href=\"/login\">Login</a></li>"; ?>
                </ul>
                <a class="donate" target="_blank"
                   href="https://cfnrv.givebig.org/c/NRV/a/cfnrv-013/">Donate</a>
            </div>
            <div class="clear" id="content">
                <div id="body">
