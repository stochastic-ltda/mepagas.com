<?php 
include(dirname(__FILE__) . '/config.php'); 
$config = new Config();
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">	
	<link rel="stylesheet" href="/assets/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="/assets/css/reveal.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/progression.css">
	
	<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/js/functions.js"></script>
	<script type="text/javascript" src="/assets/js/facebook.js"></script>
	<script type="text/javascript" src="/assets/js/progression.js"></script>
</head>
<body>	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=589467211096552";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>	
	
	<header>
		<aside class="header-wrapper">
			<div class="logo" id="divlogo">
				<a href="/"><img src="/assets/img/logo.png"/></a>
			</div>

			<div class="login-info">
				<a class="btn btn-register" href="#" data-reveal-id="regmodal">Registrar</a>
				<a class="btn btn-login" href="#" data-reveal-id="logmodal">Login</a>
				<!--
				<div class="header-login">
					<input type="text" id="li-email" placeholder="Email"> 
					<input type="password" id="li-pass" placeholder="Password"> 
					<a href="#" class="butn" onclick="userli()">Login</a>
				</div>
				<div class="fb-login-button" data-width="200" data-autologoutlink="true" data-size="large" data-onlogin="userlif()" data-scope="offline_access,user_birthday,user_likes,email"></div>
				-->
			</div>			
		</aside>
	</header>

	<section class="wrapper">		
		<div class="container">
			<?php include("route.php"); ?>
		</div>
	</section>

	<footer>
		<?php include("includes/footer.php"); ?>
	</footer>

	<script>
		$(document).ready(function() {
			checkli();
		});
	</script>

	<?php include("includes/modals.php"); ?>	

	<!-- // Scripts -->
	<script type="text/javascript" src="/assets/js/jquery.reveal.js"></script>

</body>
</html>