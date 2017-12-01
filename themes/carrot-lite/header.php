<!DOCTYPE html> 
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title( '', true, 'right' );?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header id="top">
		<nav>
			<?php wp_nav_menu( array('fallback_cb' => 'carrotlite_page_menu', 'depth' => '3', 'theme_location' => 'primary', 'link_before' => '', 'link_after' => '', 'container' => false) ); ?>
		</nav>
		<div>
			<p class="title"><a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a><span><?php bloginfo('description'); ?></span></p>
			<?php get_search_form(); ?>
		</div>
	</header>
	
	<section class="content">