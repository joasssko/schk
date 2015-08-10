<?php
/**
 * The template for displaying Archive pages.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

	<header class="archive-header">
		<h2 class="archive-title">
		<?php
			if ( is_category() ) {
				printf( __( '%s', 'renkon' ), single_cat_title( '', false ) );
			} elseif ( is_tag() ) {
				printf( __( '<span>Tagged</span> &lsquo;%s&rsquo;', 'renkon' ), single_tag_title( '', false ) );
			} elseif ( is_author() ) {
				the_post();
				printf( __( '<span>All Posts by</span> &lsquo;%s&rsquo;', 'renkon' ), '<span><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
				rewind_posts();
			} elseif ( is_day() ) {
				printf( __( '<span>Daily Archives of</span> &lsquo;%s&rsquo;', 'renkon' ), get_the_date() );
			} elseif ( is_month() ) {
				printf( __( '<span>Monthly Archives of</span> &lsquo;%s&rsquo;', 'renkon' ), get_the_date( 'F Y' ) );
			} elseif ( is_year() ) {
				printf( __( '<span>Yearly Archives of</span> &lsquo;%s&rsquo;', 'renkon' ), get_the_date( 'Y' ) );
			} else {
				_e( 'Archives', 'renkon' );
			}
				?>
		</h2>

		<?php
		if ( is_category() ) {
		// show an optional category description
		$category_description = category_description();
			if ( ! empty( $category_description ) )
				echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );

		} elseif ( is_tag() ) {
		// show an optional tag description
		$tag_description = tag_description();
			if ( ! empty( $tag_description ) )
				echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
		}
		?>
	</header><!-- end .page-header -->

			<?php rewind_posts(); ?>
			
			<div id="site-content">

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; // end of the loop. ?>

			</div><!-- end #site-content -->

		<?php /* Display navigation to next/previous pages when applicable, also check if WP pagenavi plugin is activated */ ?>
		<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<?php renkon_content_nav( 'nav-below' ); ?>
		<?php endif; ?>

		</div><!-- end .content-wrap -->

		<?php else : ?>

		<article id="post-0" class="post no-results not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Nothing Found', 'renkon' ); ?></h1>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'renkon' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</article><!-- #post-0 -->

		<?php endif; ?>
			
		<?php get_template_part( 'colophon' ); ?>

	</div><!-- end .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>