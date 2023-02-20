<?php
	global $host;
	define('PUBLIC_SITE', $host . "/site/");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">


<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Voco - IVR Manager | <?php echo $title ?> |</title>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo PUBLIC_SITE ?>css/style.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo PUBLIC_SITE ?>css/ui-lightness/jquery-ui-1.10.4.custom.css">
		<link rel="stylesheet" href="<?php echo PUBLIC_SITE?>/css/menumaker.css">
		<link rel="stylesheet" href="<?php echo PUBLIC_SITE?>libs/morrischart/morris.css">

		<script type="text/javascript" src="<?php echo PUBLIC_SITE?>js/jquery.js" ></script>
		<script type="text/javascript" src="<?php echo PUBLIC_SITE?>js/jquery-ui-1.10.4.custom.js" ></script>
		<script src="<?php echo PUBLIC_SITE?>js/jquery-menumaker.js"></script>
		<script src="<?php echo PUBLIC_SITE?>js/jquery-form-min.js"></script>
		<script src="<?php echo PUBLIC_SITE?>libs/raphael/raphael-min.js"></script>
		<script src="<?php echo PUBLIC_SITE?>libs/morrischart/morris.min.js"></script>
		
	</head>
	
	<body>
		<div id="main_wrap">
			<div id='cssmenu'>
				<ul>
				   <li class='active'><a href='<?php echo $host?>'>Dashboard</a></li>
				   <li>
				   	<a href='<?php echo $host?>/subscriber'>Subscriber</a>
				   </li>
				   <li>
				   	<a href='<?php echo $host?>/broadcast'>Broadcast</a>
				   </li>
				   <li class="btn" style="float: right">
				   	<a href="<?php echo $host?>/login" >Logout</a>
				   </li>
				</ul>


			</div>
			<!-- Top section -->
			<div id="top_wrap">
				<div class="float_left">
					<div class="float_left"><img src="<?php echo PUBLIC_SITE ?>images/phone.png" /></div>
					<div id="page_title" class="float_left">IVR Service Manager</div>
					<br class="clearfloat"/>
				</div>
				<div class="float_right" style='display:none;'>
					<div class="float_left">
						<div>User name</div>
						<div>User ID</div>
					</div>
					<div class="float_left">
						Settings button
					</div>
					<br class="clearfloat"/>
				</div>
				<br class="clearfloat"/>
			</div>