<?php
/**
 * The Main Off-Canvas Sidebar containing the primary navigation and the main widget area.
 *
 * @package Renkon
 * @since Renkon 1.0
 */
?>

<div class="secondary" role="complementary">

	<nav class="main-nav">
    <?php echo do_shortcode( '[searchandfilter taxonomies="category,post_tag"]' ); ?>

		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	</nav><!-- end .main-nav -->

	<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

		<aside id="archives" class="widget">
			<h1 class="widget-title"><?php _e( 'Archives', 'renkon' ); ?></h1>
				<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
		</aside>

		<aside id="meta" class="widget">
			<h1 class="widget-title"><?php _e( 'Meta', 'renkon' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

	<?php endif; // end sidebar widget area ?>
</div><!-- .secondary -->