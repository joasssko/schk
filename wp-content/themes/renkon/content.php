<?php
/**
 * The default template for displaying content
 *
 * @package Renkon 
 * @since Renkon 1.0
 */
?>
hi!
<?php $options = get_option('renkon_theme_options'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('postblog'); ?>>

	<?php if ( has_post_thumbnail() ): ?>

		<div class="overlay">
			<header class="entry-header">
				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
					<div class="featured-post"><?php _e( 'Featured', 'renkon' ); ?></div>
				<?php endif; ?>
				<div class="entry-postformat"><a href="<?php the_permalink(); ?>"><?php _e('Article', 'renkon') ?></a></div>
				<?php edit_post_link( __( 'Edit Post', 'renkon' ), '<div class="entry-edit"> / ', '</div>' ); ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'renkon' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			</header><!--end .entry-header -->

			<footer class="entry-meta">
				<div class="entry-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a><?php _e(' / ', 'renkon') ?></div>
				
				<div class="view-post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'renkon' ), the_title_attribute( 'echo=0' ) ); ?>"><?php _e('View Post', 'renkon') ?></a></div>
			</footer><!-- end .entry-meta -->
		</div><!-- end .overlay -->

		<div class="thumb-wrap">
			<a href="<?php the_permalink(); ?>" class="thumb"><?php the_post_thumbnail('thumbnail'); ?></a>
		</div><!-- end .thumb-wrap -->

	<?php else: ?>

			<header class="entry-header">
            
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<span class="featured-post" ><?php _e( 'Featured', 'renkon' ); ?></span>
			<?php endif; ?>
		
<h12 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'renkon' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h12>	<h15 class="entry-title"><?php the_author(); ?></h15>	
            <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<div class="featured-post"><?php _e( 'Featured', 'renkon' ); ?></div>
			<?php endif; ?>
<header class="entry-header">
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<span class="featured-post"><?php _e( 'Featured', 'renkon' );?></span>
			<?php endif; ?>
            <div class="entry-postformat"><a href="<?php the_permalink(); ?>"><?php _e('ver post | ', 'renkon') ?></a>
			 <?php the_category(' | '); ?>   | 
			 <?php the_author(); ?> | <?php edit_post_link( __( 'Edit Post', 'renkon' ), '<div class="entry-edit"> ', '</div>' ); ?></div>
			<div class="entry-postformat2"><?php echo get_the_date(); ?></a><?php _e('', 'renkon') ?></div>
</header>

		<div class="entry-content">
		<?php if( $options['show-excerpt'] || is_search () ) : // Show excerpts if the theme option is activated and on search results. ?>
			<?php the_excerpt(); ?>
		<?php else : ?>
			<?php the_content( __( 'Read more', 'renkon' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'renkon' ), 'after' => '</div>' ) ); ?>
		<?php endif; ?>
		</div><!-- end .entry-content -->


	<?php endif; ?>

</article><!-- end post -<?php the_ID(); ?> -->