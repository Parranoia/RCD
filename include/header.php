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
				print("<a class=\"right\" href=\"/logout\">Logout (" . $_SESSION['user']['username'] . ")</a>\n");
		?>
        <div id="header">
            <h1>Radford Child Development Inc.</h1>
            <img src="/images/banner.jpg">
        </div>
        <div id="wrapper">
            <div class="clear" id="nav">
                <ul>
<?php
$query = 'SELECT name FROM pages ORDER BY position ASC';
try
{
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch (PDOException $e)
{
    die();
}
$rows = $stmt->fetchAll();
foreach ($rows as $row)
    echo "\t\t    <li><a href=\"/" . $row['name'] . "\">" . ucfirst($row['name']) . "</a></li>\n";

if (!isset($_SESSION['user'])) 
    echo "<li><a href=\"/login\">Login</a></li>";
?>
                </ul>
                <a class="donate" target="_blank"
                   href="https://cfnrv.givebig.org/c/NRV/a/cfnrv-013/">Donate</a>
            </div>
            <div class="clear" id="content">
                <div id="body">
