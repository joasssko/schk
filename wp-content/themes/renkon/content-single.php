<?php
/**
 * The default template for single posts
 *
 * @package Renkon 
 * @since Renkon 1.0
 */
?>

<?php $options = get_option('renkon_theme_options'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() &&  false == get_post_format() ) : // Show thumbnails on standard posts. ?>
		<div class="thumb-single"><?php the_post_thumbnail(); ?></div>
	<?php endif; ?>

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
			<?php endif; ?><br>
            <div class="entry-postformat"><a href="<?php the_permalink(); ?>"></a>
            
			 <?php the_category($separator = ' | ', $parents, $post_id); ?>  | 
			 <?php the_author(); ?> |
             <?php echo get_the_date(); ?></a><?php _e('', 'renkon') ?></div>
			
</header><div class="entry-postformat3">  <?php get_the_subtitle(); ?></div>
	<div class="entry-content">
  

	<?php if( is_search () ) : // Show excerpts on search results. ?>
		<?php the_excerpt(); ?>
	<?php else : ?>
		<?php the_content( __( 'Read more', 'renkon' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'renkon' ), 'after' => '</div>' ) ); ?>
	<?php endif; ?>
	</div><!-- end .entry-content -->

	<?php if ( get_the_author_meta('description') &&  false == get_post_format() ) : // Show authors bio on standard posts. ?>
		<div class="author-info">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'renkon_author_bio_avatar_size', 40 ) ); ?>
			<div class="author-details">
				<h3><?php the_author(); ?></h3>
				<?php if( $options['custom_authorlinks'] ) : // if author social links are filled out in the theme optons. ?>
					<p class="author-links"><span><?php _e('Find me on: ', 'renkon') ?></span><?php echo stripslashes($options['custom_authorlinks']); ?></p>
				<?php endif; ?>
			</div><!-- end .author-details -->
			<p class="author-description"><?php the_author_meta( 'description' ); ?></p>	
		</div><!-- end .author-info -->
	<?php endif; ?>

	<footer class="entry-meta clearfix">
		<div class="postinfo-wrap">
		<?php if ( has_category() ) : ?>
			<div class="entry-cats"><span><?php _e('Category ', 'renkon') ?></span><?php the_category(', '); ?></div>
		<?php endif; // has_category() ?>
		<?php $tags_list = get_the_tag_list( '', ', ' ); 
		if ( $tags_list ): ?>
			<div class="entry-tags"><span><?php _e('Tags', 'renkon') ?></span> <?php the_tags( '', ', ', '' ); ?></div>
		<?php endif; // get_the_tag_list() ?>
			<?php edit_post_link( __( 'Edit Post', 'renkon' ), '<div class="entry-edit">(', ')</div>' ); ?>
		</div><!-- end .postinfo-wrap -->
		<?php // // Include Share Buttons on single posts
			$options = get_option('renkon_theme_options');
			if($options['share-posts']) : ?>
			<?php get_template_part( 'share'); ?>
		<?php endif; ?>
	</footer><!-- end .entry-meta -->

</article><!-- end post -<?php the_ID(); ?> -->