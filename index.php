<?php session_start(); ?>
<?php ob_start('ob_gzhandler'); ?>
<?php require_once('start.php'); ?>
<?php $sitename="Cash-Flow"; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">	
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
	<!-- <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" type="text/css" /> -->
	<link rel="stylesheet" href="css/animate.css" type="text/css" />
	<title><?=$sitename?> - создай свой финансовый поток!</title>
	<meta name="description" content="<?=$sitename;?>">
	<?php 
	if (isset($_GET['page']))
	{ if ($_GET['page']=='webinar')	include 'vk_comments_head.php'; } 
	?>

</head>
<body>
	<?php include 'menu.php'; ?>
	<?php include 'header.php'; ?> 
		<div>
			 <?php
				$page = "main";
				if (isset($_GET['page']))
				{
				    $page = $_GET['page'];  
				}
				include "page.".$page.".php";
			?> 
		
		</div>
	<?php include 'footer.php'; ?>



<script src="js/prefixfree.min.js"></script>
<script src="js/wow.min.js"></script>
<script>wow = new WOW({
boxClass: 'wow',
animateClass: 'animated',
offset: 0,
mobile: true,
live: true
})
wow.init();</script>
</body>
</html>
