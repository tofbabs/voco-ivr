<?php
	global $host;
	define('PUBLIC_SITE', $host . "/site/");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">


<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Voco - IVR Manager | Login</title>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo PUBLIC_SITE ?>css/style.css">	
	</head>
	
	<body>
		<div id="main_wrap">
			<div id='cssmenu'>

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
			<!-- Middle section -->
			<div id="mid_wrap">

				<!-- Report Viewport -->
				<div>
					<!-- Data Graph -->
					<div id="report">
						<div id="top_msisdn" class="float_center">
							<div class="viewport_title">Login</div>
							<div class="viewport_canvas">
								<form id="login" action="<?php echo $host ?>/dashboard" method="POST">
									<p><input type="text" name="username" placeholder="Username" /></p>
									<p><input type="password" name="password" placeholder="Password" /></p>
									<p><input type="submit" class="btn" value="Sign in" name="loginBtn" /></p>
								</form>	
							</div>
						</div>

						<br class="clearfloat"/>
					</div>
					
				</div>

				
			</div>
			
			<!-- Bottom section -->
			<div id="btm_wrap">

			</div>
		</div>
	</body>

<?php include_once 'footer.php'; ?>