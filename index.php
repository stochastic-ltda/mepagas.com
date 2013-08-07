<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MePagas.com - Gana dinero publicando GRATIS tu pituto.</title>
	<link rel="stylesheet" href="/assets/css/style.css"/>
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