<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

get_header(); ?>

		<div id="site-content2" style="width:100%" >

			<?php while ( have_posts() ) : the_post(); ?> 
    
                    <?php get_template_part( 'content', 'single' ); ?>
    
                    

			<?php endwhile; // end of the loop. ?>
	
		</div><!-- end #site-content -->
		
		<nav class="nav-single clearfix">
			<div class="nav-previous"><?php next_post_link( '%link', __( 'Next Post  &rarr;', 'renkon' ) ); ?></div>
			<div class="nav-next"><?php previous_post_link( '%link', __( '&larr; Previous Post', 'renkon' ) ); ?></div>
		</nav><!-- end .nav-below -->
		
		</div><!-- end .content-wrap -->
		
		<?php get_template_part( 'colophon' ); ?>

	</div><!-- end .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>