<?php
/**
 * The template for Image Posts
 *
 * @package Renkon
 * @since Renkon 1.0
 */
?>

<?php $options = get_option('renkon_theme_options'); ?>

<?php $disciplinas = wp_get_post_terms( $post->ID, 'disciplina' )?>
<?php $artistas = wp_get_post_terms( $post->ID, 'artistas' )?>
<?php $tipos = wp_get_post_terms( $post->ID, 'tipo' )?>


<article id="post-<?php the_ID(); ?>" <?php //post_class('postblog'); ?> class="postblog post <?php echo 'at-'.$artistas[0]->term_id;?> <?php echo 'pd-'.$disciplinas[0]->term_id;?> <?php echo 'td-'.$tipos[0]->term_id;?>">
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'renkon' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>	<h3 class="entry-title"><?php echo $artistas[0]->name ?></h3>	
            <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<div class="featured-post"><?php _e( 'Featured | ', 'renkon' ); ?></div>
			<?php endif; ?>
<header class="entry-header">
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<span class="featured-post"><?php _e( 'Featured | ', 'renkon' );?></span>
			<?php endif; ?>
            
            <div class="entry-postformat"><a href="<?php the_permalink(); ?>"><?php _e('ver post | ', 'renkon') ?></a>
			 <?php echo $tipos[0]->name ?>   |  
			 <?php echo $disciplinas[0]->name ?> | <?php edit_post_link( __( 'Editar Post', 'renkon' ), '<div class="entry-edit"> ', '</div>' ); ?></div>
			<div class="entry-postformat2"><?php echo get_the_date(); ?></a><?php _e('', 'renkon') ?></div>
</header>

	<?php if ( has_post_thumbnail() ) {
		echo '<a href="'; the_permalink(); echo '" class="thumb">';
		the_post_thumbnail('thumbnail');
		echo '</a>';
	} else {
		echo '<a href="'; the_permalink(); echo '" class="thumb">';
		echo '<img src="';
		echo catch_first_image();
		echo '" alt="" />';
echo '</a>';
	} ?>            

</article>