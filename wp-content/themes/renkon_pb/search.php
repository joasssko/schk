<?php
/**
 * The template for displaying search results.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

get_header(); ?>

		<?php if ( have_posts() ) : ?>
		<header class="archive-header">
			<h2 class="archive-title"><?php echo $wp_query->found_posts; ?> <?php printf( __( '<span>Search Results for</span> &lsquo;%s&rsquo;', 'renkon' ), '' . get_search_query() . '' ); ?></h2>
		</header><!--end .archive-header -->
		
		<div id="site-content">

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php	get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; // end of the loop. ?>
		
		</div><!--end #site-content -->

		<?php /* Display navigation to next/previous pages when applicable, also check if WP pagenavi plugin is activated */ ?>
			<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<?php renkon_content_nav( 'nav-below' ); ?>
		<?php endif; ?>

		<?php else : ?>
		

		<article id="post-0" class="page no-results not-found">		
			<header class="archive-header">
				<h2 class="archive-title"><?php _e( 'Nothing Found', 'renkon' ); ?></h2>
			</header><!--end .archive-header -->

			<div class="entry-content">
				<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'renkon' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- end .entry-content -->				
		</article>

		<?php endif; ?>

</div><!-- end .content-wrap -->

		<?php get_template_part( 'colophon' ); ?>

	</div><!-- end .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>