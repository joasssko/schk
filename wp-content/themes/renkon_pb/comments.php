<?php
/**
 * The template for displaying Comments.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div class="comments-wrap">
	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( _n( '(1) Comment', '(%1$s) Comments', get_comments_number(), 'renkon' ),
					number_format_i18n( get_comments_number() ) );
			?>
			<?php if ( comments_open() ) : ?>
			<span><a href="#reply-title"><?php _e( 'Write a comment', 'renkon' ); ?></a></span>
			<?php endif; // comments_open() ?>
		</h3>

		<ol class="commentlist">
			<?php
				wp_list_comments( array(
					'callback' => 'renkon_comment'
				) );
			?>
		</ol><!-- end .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav class="comment-nav" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'renkon' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'renkon' ) ); ?></div>
		</nav><!-- end .comment-nav -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are no comments, let's leave a little note
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'renkon' ); ?></p>
	<?php endif; ?>

	<?php comment_form (
		array(
			'title_reply' =>__( '<h3 id="reply-title">Leave a Comment</h3>', 'renkon'),
			'comment_notes_before' =>__( '<p class="comment-note">Required fields are marked <span class="required">*</span>.</p>', 'renkon'),
			'comment_notes_after' =>(''),
			'comment_field'  => '<p class="comment-form-comment"><label for="comment">' . _x( 'Message <span class="required">*</span>', 'noun', 'renkon' ) . 			'</label><br/><textarea id="comment" name="comment" rows="8"></textarea></p>',
			'label_submit'	=> __( 'Send Comment', 'renkon' ))
		); 
	?>

	</div><!-- #comments .comments-area -->
</div><!-- .comments-wrap -->
