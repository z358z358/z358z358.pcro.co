<?php
//	IE
if( strpos( $_SERVER['HTTP_USER_AGENT'] , 'MSIE' ) ) $html['html5_js'] = '<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><link type=""<![endif]-->';
?><!doctype html>
<!--[if IE 8]><html lang="en" class="ie8"><![endif]-->
<!--[if IE 9]><html lang="en" class="ie9"><![endif]-->
<!--[if !IE]><!--><html lang="zh-TW"><!--<![endif]-->
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta content="yes" name="apple-mobile-web-app-capable" /><? //允許全螢幕瀏覽 ?>
<meta name="Keywords" content="<?=$html['keyword']?>" />
<meta name="title" content="<?=$html['title']?>" />
<meta name="description" content="<?=$html['description']?>" />
<meta name="Robots" content="all" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<?=meta_og($sys['meta_og'])?>
<?=$sys['fb_share_image']?>
<title><?=$html['title']?></title>
	<?=$html['html5_js']?>
	<?=$html['head']?>
</head>
<body id="<?=$html['body_id']?>" class="<?=$html['body_class']?>">

	<section id="wrapper">
		<header id="header" class="<?=$html['header_class']?>">
		<?=$html['header']?>
		</header>

		<section id="bodyer" class="<?=$html['bodyer_class']?>">
		<?=$html['bodyer']?>
		</section>

		<footer id="footer">
		<?=$html['footer']?>
		</footer>
	</section>

	<?=$html['bottom']?>
	<?=$html['load_time']?>	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<?=$html['bottom_js']?>
	<script>/* google  Analytics */
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-53250580-1', 'auto');
	  ga('send', 'pageview');
	</script>
	<script type="text/javascript">
	$(document).ready(function() {
		<?=$html['ready_js']?>
	});
	</script>
	<?=$html['error']?>
</body>
</html>