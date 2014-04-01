<!DOCTYPE html>
<html>
    <head>
        <title>Radford Child Development</title>
        <link rel="stylesheet" type="text/css" href="/css/smoothness/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="/css/default.css">
        <script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>
        <meta charset="utf-8">
        <meta name="keywords" content="radford, radford childcare, childcare, child care, daycare, radford daycare, radford child development, daycare">
    </head>
    <body>
        <?php 
    	if (isset($_SESSION['user'])) {
    	    print("<div class=\"right\">\n");
			print("<a href=\"/logout\">Logout (" . $_SESSION['user']['username'] . ")</a>\n");
            
            if ($_SESSION['user']['privilege'] !== 0)
                print(" | <a href=\"/admin\">Admin</a>\n");
            
            print("</div>");
        }
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
