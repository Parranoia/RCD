<!DOCTYPE html>
<html>
    <head>
        <title>Radford Child Development</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="stylesheet" type="text/css" href="/font_awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/admin/css/admin.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="nav">
            	<ul>
                    <li><a href="/admin/home"><i class="fa fa-home fa-fw"></i> Home</a></li>
                    <?php if ($_SESSION['user']['privilege'] === 2) echo "<li><a href=\"/admin/users\"><i class=\"fa fa-users fa-fw\"></i> Manage Users</a></li>\n"; ?>
                    <li><a href="/admin/manage_pages"><i class="fa fa-file-text fa-fw"></i> Manage Pages</a></li>                   
                    <li><a href="/admin/interested"><i class="fa fa-list fa-fw"></i> View Interested List</a></li>
            	</ul>
            </div>
            <div class="content">
