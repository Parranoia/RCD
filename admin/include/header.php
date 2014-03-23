<!DOCTYPE html>
<html>
    <head>
        <title>Radford Child Development</title>
        <link rel="stylesheet" type="text/css" href="/font_awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="/admin/css/admin.css">
        <script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <meta charset="utf-8">
        <meta name="keywords" content="radford, radford childcare, childcare, child care, daycare, radford daycare, radford child development, daycare">
    </head>
    <body>
        <div class="wrapper">
            <div class="nav">
            	<ul>
                    <li><a href="/admin/home"><i class="fa fa-home fa-fw"></i> Home</a></li>
                    <?php if ($_SESSION['user']['privilege'] === 2) print('<li><a href="/admin/users"><i class="fa fa-users fa-fw"></i> Manage Users</a></li>'); ?>
                    <li><a href="/admin/manage_pages"><i class="fa fa-file-text fa-fw"></i> Manage Pages</a></li>                   
                    <li><a href="/admin/interested"><i class="fa fa-list fa-fw"></i> View Interested List</a></li>
                    <li><a href="#"><i class="fa fa-arrow-up fa-fw"></i> Upload file</a></li>
                    <li><a href="#"><i class="fa fa-cog fa-fw"></i> Manage files</a></li>
            	</ul>
            </div>
            <div class="content">
