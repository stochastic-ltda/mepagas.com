<?php 
include(dirname(__FILE__) . '/config.php'); 
$config = new Config();
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MePagas.com - Gana dinero publicando GRATIS tu pituto.</title>
	<link rel="stylesheet" href="/assets/css/style.css"/>
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="/assets/js/functions.js"></script>
</head>
<body>
	
	<header>
		<aside class="header-wrapper">
			<div class="<?=($_SERVER['REQUEST_URI']!="/")?'logo-despliegue':'logo'?>">
				<a href="/"><img src="/assets/img/logo.png"/></a>
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

</body>
</html>