<?php
/**
 * Template Name: Archive Page Template
 * Description: An archive page template
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

get_header(); ?>

	<div id="site-content" class="clearfix">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


			<div class="entry-content clearfix">
				<h3 class="archivepage-title"><?php _e('Filter by Tags', 'renkon') ?></h3>
				<div class="archive-tags clearfix">
					<?php wp_tag_cloud('orderby=count&number=50'); ?> 
				</div><!-- end .archive-tags -->

				<h3 class="archivepage-title"><?php _e('The Latest 50 Posts', 'renkon') ?></h3>
				<ul class="latest-posts-list">
					<?php wp_get_archives('type=postbypost&limit=50'); ?>  
				</ul><!-- end .latest-posts-list -->

				<h3 class="archivepage-title"><?php _e('The Monthly Archive', 'renkon') ?></h3>
				<ul class="monthly-archive-list">
					<?php wp_get_archives('type=monthly'); ?>  
				</ul><!-- end .monthly-archive-list -->
			</div><!-- end .entry-content -->

		</article><!-- end post-<?php the_ID(); ?> -->

	</div><!-- end #site-content -->

	</div><!-- end .content-wrap -->

	<?php get_template_part( 'colophon' ); ?>

</div><!-- end .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
