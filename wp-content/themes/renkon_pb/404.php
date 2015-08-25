<?php
/**
 * The template for displaying 404 error pages.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

get_header(); ?>

	<div id="site-content">
		<article id="post-0" class="page error404 not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Not Found', 'renkon' ); ?></h1>
			</header><!--end .entry-header -->

			<div class="entry-content">
				<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'renkon' ); ?></p>
			</div><!-- end .entry-content -->

			<script type="text/javascript">
				// focus on search field after it has loaded
				document.getElementById('s') && document.getElementById('s').focus();
			</script>
		</article><!-- end #post-0 -->
	</div><!-- end #site-content -->
	
	</div><!-- end .content-wrap -->

		<?php get_template_part( 'colophon' ); ?>

	</div><!-- end .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>