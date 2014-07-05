<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<title><?php wp_title('&laquo;', true, 'right'); ?></title>
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>    
    
	<script src="<?php bloginfo('template_url');?>/_resources/js/libs/modernizr-2.6.2.min.js"></script>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!--[if lt IE 8]>
        <div class="browser-message">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</div>
    <![endif]-->
	        
    <section class="container">
		<header>
			<a class="logo" href="<?php bloginfo('url') ?>"><?php bloginfo('name') ?></a>
			<?php wp_nav_menu( array('theme_location' => 'main-navigation', 'container' => false, 'menu_class' => 'main-navigation navigation horizontal' )); ?>
		</header>
