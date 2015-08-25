<?php
/**
 * The template for displaying standard pages.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

get_header(); ?>

		<div id="site-content" class="clearfix">
        

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- end #site-content -->

		</div><!-- end .content-wrap -->

		<?php get_template_part( 'colophon' ); ?>

	</div><!-- end .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>