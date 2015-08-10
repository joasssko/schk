<?php
/**
 * The main template file.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

get_header(); ?>

		<?php if ( have_posts() ) : ?>

		<div id="site-content">

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

		</div><!-- end #site-content -->

		<?php /* Display navigation to next/previous pages when applicable, also check if WP pagenavi plugin is activated */ ?>
		<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<?php renkon_content_nav( 'nav-below' ); ?>
		<?php endif; ?>

		<?php endif; ?>

		</div><!-- end .content-wrap -->

		<?php get_template_part( 'colophon' ); ?>

	</div><!-- end .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>