<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->

	<head>
		<meta charset="UTF-8" />
		
		<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
		
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
		<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
        
		<?php wp_enqueue_script("jquery"); ?>
		<?php wp_head(); ?>
        
  		<script src="<?php bloginfo('template_url');?>/resources/js/libs/modernizr-2.0.6.min.js"></script>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"></script>
		<script>window.jQuery || document.write('<script src="<?php bloginfo('template_url'); ?>/resources/js/libs/jquery-1.6.2.min.js">\x3C/script>')</script>
        
	</head>
	
	<body <?php body_class(); ?>>
	
    <section id="container">
		<header>
			<?php wp_nav_menu( array('menu' => 'Main', 'container' => false, )); ?>
		</header>
