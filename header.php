<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php wp_title() ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/css/bootstrap-combined.min.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png" />
	<?php wp_head(); ?>
</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="#">WP Utility Belt</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="active"><a href="#home">Home</a></li>
						<li><a href="#wordpress">Hook</a></li>
						<li><a href="#elasticsearch">Elasticsearch</a></li>
						<li><a href="#passwords">Passwords</a></li>
						<li><a href="#regex">Regex</a></li>
						<li><a href="#time">Date &amp; Time</a></li>
						<li><a href="#printf">Printf</a></li>
						<li><a href="#serialization">Serialization</a></li>
						<li><a href="#benchmark">Benchmark</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div id="wrapper" class="container">
		<div id="view_wrapper" class="row">