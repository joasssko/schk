<?php
/**
 * The template for displaying an optional footer nav and the site info.
 *
 * @package Renkon
 * @since Renkon 1.0
 */
?>

<div class="colophon" role="contentinfo">
	<div class="site-info">
	<?php
		$options = get_option('renkon_theme_options');
		if($options['custom_footertext'] != '' ){
			echo ('<ul class="credit"><li>');
			echo stripslashes($options['custom_footertext']);
			echo ('</li></ul>');
		} else { ?>
	<?php } ?>

	</div><!-- end .site-info -->

	<?php if (has_nav_menu('optional' )) {
		wp_nav_menu( array('theme_location' => 'optional', 'container' => 'nav' , 'container_class' => 'footer-nav', 'depth' => 1 ));}
	?>

</div><!-- end .colophon -->