<?php
/**
 * The theme Header.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */
?><!DOCTYPE html>
<html  id="doc" class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php $options = get_option('renkon_theme_options'); ?>
<?php if( $options['custom_favicon'] != '' ) : ?>
<link rel="shortcut icon" type="image/ico" href="<?php echo $options['custom_favicon']; ?>" />
<?php endif  ?>
<?php if( $options['custom_apple_icon'] != '' ) : ?>
<link rel="apple-touch-icon" href="<?php echo $options['custom_apple_icon']; ?>" />
<?php endif  ?>
<script type="text/javascript">
	var doc = document.getElementById('doc');
	doc.removeAttribute('class', 'no-js');
	doc.setAttribute('class', 'js');
</script>
      
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" />
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="menu">

	<header id="site-header" role="banner">

		<nav class="off-canvas-nav"> <a href="http://localhost:8888"><img src="http://www.schkolnick.com/wp-content/uploads/2014/08/logo2.jpg" width="300"  margin-top="10px" height="100" " alt=""/></a>
			<span class="sidebar-item"><a class="sidebar-button" href="#sidebar" title="<?php _e( 'Filtrar +', 'renkon' ); ?>"><?php _e( 'Filtrar +', 'renkon' ); ?></a><?php do_action('show_beautiful_filters'); ?>
</span>
		</nav><!-- end .off-canvas-navigation -->

</header><!-- end #site-header -->

	<a class="mask-right" href="#menu"></a>

	<div class="column-wrap">

	<div class="container">

		<?php $header_image = get_header_image();
			if ( ! empty( $header_image ) and is_front_page()) : ?>
			<div id="header-image" style="background-image: url(<?php echo esc_url( $header_image ); ?>); " >
				<div class="header-outer">
					<div class="header-inner">
						<?php if( $options['header-slogan'] ) : ?>
							<p class="header-slogan"><?php echo stripslashes($options['header-slogan']); ?></p>
						<?php endif; ?>
						<?php if( $options['header-subtitle'] ) : ?>
							<p class="header-subtitle"><?php echo stripslashes($options['header-subtitle']); ?></p>
						<?php endif; ?>
						<?php if( $options['header-slogan'] ) : ?>
							<a href="#content-wrap" class="header-btn"><?php _e( 'Show Content', 'renkon' ); ?></a>
						<?php endif; ?>
					</div><!-- end .header-inner -->
				</div><!-- end .header-outer -->
			</div><!-- end .header-image -->
		<?php endif; ?>

		<div id="content-wrap">
	