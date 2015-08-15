<?php 
//Agrega filtros para categorías
//Disciplina
//Fotografo
//Tipo

register_taxonomy("disciplina", array('post'), array("hierarchical" => true, "label" => "Disciplinas", "singular_label" => "Disciplina", "rewrite" => true));
register_taxonomy("artistas", array('post'), array("hierarchical" => true, "label" => "Artistas", "singular_label" => "Artista", "rewrite" => true));
register_taxonomy("tipo", array('post'), array("hierarchical" => true, "label" => "Tipos", "singular_label" => "Tipo", "rewrite" => true));

?><?php
/**
 * Renkon functions and definitions
 *
 * @package Renkon
 * @since Renkon 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Set the content width based on the theme's design and stylesheet.style.css
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) )
	$content_width = 720; /* pixels */

/*-----------------------------------------------------------------------------------*/
/* Sets up theme defaults and registers support for various WordPress features.
/*-----------------------------------------------------------------------------------*/
/**
 * Tell WordPress to run renkon_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'renkon_setup' );

if ( ! function_exists( 'renkon_setup' ) ):
/**
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override renkon_setup() in a child theme, add your own renkon_setup to your child theme's
 * functions.php file.
 */
function renkon_setup() {

	// Make Renkon available for translation. Translations can be filed in the /languages/ directory.
	load_theme_textdomain( 'renkon', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up the Renkon theme options page and related code.
	require( get_template_directory() . '/inc/theme-options.php' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu().
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'renkon' ),
		'optional' => __( 'Footer Navigation (no sub menus supported)', 'renkon' )
	) );

	add_theme_support( 'post-formats', array(
		'image', 'gallery'
	) );

}
endif; // renkon_setup

/*-----------------------------------------------------------------------------------*/
/*   Adds support for a custom header image.
/*-----------------------------------------------------------------------------------*/

require( get_template_directory() . '/inc/custom-header.php' );

/*-----------------------------------------------------------------------------------*/
/*  Enqueue scripts and styles
/*-----------------------------------------------------------------------------------*/

function renkon_scripts() {
	global $wp_styles;

	// Adds JavaScript to pages with the comment form to support sites with threaded comments (when in use)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );

	// Adds JavaScript for Masonry
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/jquery.masonry.min.js', array( 'jquery' ), '2.1.08' );

	// Adds JavaScript ImagesLoaded
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js', array( 'jquery' ), '3.0.2' );

	// Adds JavaScript for Infinite Scroll
	$options = get_option('renkon_theme_options');
	if ($options['inf_scroll'])
	wp_enqueue_script( 'infinitescroll', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array( 'jquery' ), '1.0' );

	// Adds JavaScript for Masonry
	$options = get_option('renkon_theme_options');
	if ($options['inf_scroll'])
	wp_enqueue_script( 'masonrygridscroll', get_template_directory_uri() . '/js/masonrygrid.scroll.js', array( 'jquery' ), '1.0' );
	else
	wp_enqueue_script( 'masonrygrid', get_template_directory_uri() . '/js/masonrygrid.js', array( 'jquery' ), '1.0' );


	// Adds JavaScript for scalable videos
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1' );

	// Adds JavaScript for scalable header slogan text
	wp_enqueue_script( 'fittext', get_template_directory_uri() . '/js/jquery.fittext.js', array( 'jquery' ), '1.2' );


	// Adds Custom Renkon JavaScript for Off Canvas layout
	wp_enqueue_script( 'renkon-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0' );


	// Loads Google Webfonts stylesheet
	$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Lato:400,700,400italic,700italic|Playfair+Display:400,700,400italic,700italic&subset=latin,latin-ext',
		);
	wp_enqueue_style( 'googlefonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );

	// Loads main stylesheet.
	wp_enqueue_style( 'style', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'renkon_scripts' );


/*-----------------------------------------------------------------------------------*/
/* A more formatted title element for the head tag
/*-----------------------------------------------------------------------------------*/
function renkon_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'renkon' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'renkon_wp_title', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/* Include theme options in the theme customizer
/*-----------------------------------------------------------------------------------*/
function renkon_customize_register( $wp_customize ) {
//All our sections, settings, and controls will be added here

}
add_action( 'customize_register', 'renkon_customize_register' );

/*-----------------------------------------------------------------------------------*/
/* Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
/*-----------------------------------------------------------------------------------*/
function renkon_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'renkon_page_menu_args' );


/*-----------------------------------------------------------------------------------*/
/* Catch first image of image post if no thumbnail is available
/*-----------------------------------------------------------------------------------*/
function catch_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];

  return $first_img;
}

/*-----------------------------------------------------------------------------------*/
/* Number of tags in the tagcoud widget
/*-----------------------------------------------------------------------------------*/
add_filter( 'widget_tag_cloud_args', 'renkon_widget_tag_cloud_args' );
function renkon_widget_tag_cloud_args( $args ) {
	$args['number'] = 30;
	return $args;
}

/*-----------------------------------------------------------------------------------*/
/* Sets the post excerpt length to 40 characters.
/*-----------------------------------------------------------------------------------*/
function renkon_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'renkon_excerpt_length' );

/*-----------------------------------------------------------------------------------*/
/* Returns a "Continue Reading" link for excerpts
/*-----------------------------------------------------------------------------------*/
function renkon_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Read more', 'renkon' ) . '</a>';
}

/*-----------------------------------------------------------------------------------*/
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and renkon_continue_reading_link().
/*
/* To override this in a child theme, remove the filter and add your own
/* function tied to the excerpt_more filter hook.
/*-----------------------------------------------------------------------------------*/
function renkon_auto_excerpt_more( $more ) {
	return ' (&hellip;)' . renkon_continue_reading_link();
}
add_filter( 'excerpt_more', 'renkon_auto_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Adds a pretty "Continue Reading" link to custom post excerpts.
/*
/* To override this link in a child theme, remove the filter and add your own
/* function tied to the get_the_excerpt filter hook.
/*-----------------------------------------------------------------------------------*/
function renkon_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= renkon_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'renkon_custom_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Remove inline styles printed when the gallery shortcode is used.
/*-----------------------------------------------------------------------------------*/
function renkon_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'renkon_remove_gallery_css' );



/*-----------------------------------------------------------------------------------*/
/* Register widgetized areas
/*-----------------------------------------------------------------------------------*/
function renkon_widgets_init() {

	register_sidebar( array (
		'name' => __( 'Sidebar', 'renkon' ),
		'id' => 'sidebar-1',
		'description' => __( 'Widgets will appear in the off-canvas sidebar below the main navigation.', 'renkon' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'init', 'renkon_widgets_init' );


if ( ! function_exists( 'renkon_content_nav' ) ) :

/*-----------------------------------------------------------------------------------*/
/* Display navigation to next/previous pages when applicable
/*-----------------------------------------------------------------------------------*/
function renkon_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="clearfix">
			<div class="nav-previous"><?php next_posts_link( __( ' + antiguos', 'renkon'  ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( ' + nuevos', 'renkon' ) ); ?></div>
		</nav><!-- end #nav-below -->
	<?php endif;
}

endif; // renkon_content_nav

/*-----------------------------------------------------------------------------------*/
/* Removes the default CSS style from the WP image gallery
/*-----------------------------------------------------------------------------------*/
add_filter('gallery_style', create_function('$a', 'return "
<div class=\'gallery\'>";'));


/*-----------------------------------------------------------------------------------*/
/* Extends the default WordPress body classes
/*-----------------------------------------------------------------------------------*/
function renkon_body_class( $classes ) {

	if ( is_page_template( 'page-templates/page-archive.php' ) )
		$classes[] = 'template-archive';

	if ( is_page_template( 'page-templates/page-fullwidth.php' ) )
		$classes[] = 'template-fullwidth';

	if ( get_header_image() == '' )
		$classes[] = 'no-header';

	return $classes;
}
add_filter( 'body_class', 'renkon_body_class' );

/*-----------------------------------------------------------------------------------*/
/* Renkon Shortcodes
/*-----------------------------------------------------------------------------------*/
// Enable shortcodes in widget areas
add_filter( 'widget_text', 'do_shortcode' );

// Replace WP autop formatting
if (!function_exists( "renkon_remove_wpautop")) {
	function renkon_remove_wpautop($content) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Multi Columns Shortcodes
/* Don't forget to add "_last" behind the shortcode if it is the last column.
/*-----------------------------------------------------------------------------------*/

// Two Columns
function renkon_shortcode_two_columns_one( $atts, $content = null ) {
   return '<div class="two-columns-one">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one', 'renkon_shortcode_two_columns_one' );

function renkon_shortcode_two_columns_one_last( $atts, $content = null ) {
   return '<div class="two-columns-one last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one_last', 'renkon_shortcode_two_columns_one_last' );

// Three Columns
function renkon_shortcode_three_columns_one($atts, $content = null) {
   return '<div class="three-columns-one">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one', 'renkon_shortcode_three_columns_one' );

function renkon_shortcode_three_columns_one_last($atts, $content = null) {
   return '<div class="three-columns-one last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one_last', 'renkon_shortcode_three_columns_one_last' );

function renkon_shortcode_three_columns_two($atts, $content = null) {
   return '<div class="three-columns-two">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two', 'renkon_shortcode_three_columns_two' );

function renkon_shortcode_three_columns_two_last($atts, $content = null) {
   return '<div class="three-columns-two last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two_last', 'renkon_shortcode_three_columns_two_last' );

// Four Columns
function renkon_shortcode_four_columns_one($atts, $content = null) {
   return '<div class="four-columns-one">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one', 'renkon_shortcode_four_columns_one' );

function renkon_shortcode_four_columns_one_last($atts, $content = null) {
   return '<div class="four-columns-one last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one_last', 'renkon_shortcode_four_columns_one_last' );

function renkon_shortcode_four_columns_two($atts, $content = null) {
   return '<div class="four-columns-two">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two', 'renkon_shortcode_four_columns_two' );

function renkon_shortcode_four_columns_two_last($atts, $content = null) {
   return '<div class="four-columns-two last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two_last', 'renkon_shortcode_four_columns_two_last' );

function renkon_shortcode_four_columns_three($atts, $content = null) {
   return '<div class="four-columns-three">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three', 'renkon_shortcode_four_columns_three' );

function renkon_shortcode_four_columns_three_last($atts, $content = null) {
   return '<div class="four-columns-three last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three_last', 'renkon_shortcode_four_columns_three_last' );

// Five Columns
function renkon_shortcode_five_columns_one($atts, $content = null) {
   return '<div class="five-columns-one">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_one', 'renkon_shortcode_five_columns_one' );

function renkon_shortcode_five_columns_one_last($atts, $content = null) {
   return '<div class="five-columns-one last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_one_last', 'renkon_shortcode_five_columns_one_last' );

function renkon_shortcode_five_columns_two($atts, $content = null) {
   return '<div class="five-columns-two">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_two', 'renkon_shortcode_five_columns_two' );

function renkon_shortcode_five_columns_two_last($atts, $content = null) {
   return '<div class="five-columns-two last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_two_last', 'renkon_shortcode_five_columns_two_last' );

function renkon_shortcode_five_columns_three($atts, $content = null) {
   return '<div class="five-columns-three">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_three', 'renkon_shortcode_five_columns_three' );

function renkon_shortcode_five_columns_three_last($atts, $content = null) {
   return '<div class="five-columns-three last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_three_last', 'renkon_shortcode_five_columns_three_last' );

function renkon_shortcode_five_columns_four($atts, $content = null) {
   return '<div class="five-columns-four">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_four', 'renkon_shortcode_five_columns_four' );

function renkon_shortcode_five_columns_four_last($atts, $content = null) {
   return '<div class="five-columns-four last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'five_columns_four_last', 'renkon_shortcode_five_columns_four_last' );

// Six Columns
function renkon_shortcode_six_columns_one($atts, $content = null) {
   return '<div class="six-columns-one">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_one', 'renkon_shortcode_six_columns_one' );

function renkon_shortcode_six_columns_one_last($atts, $content = null) {
   return '<div class="six-columns-one last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_one_last', 'renkon_shortcode_six_columns_one_last' );

function renkon_shortcode_six_columns_two($atts, $content = null) {
   return '<div class="six-columns-two">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_two', 'renkon_shortcode_six_columns_two' );

function renkon_shortcode_six_columns_two_last($atts, $content = null) {
   return '<div class="six-columns-two last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_two_last', 'renkon_shortcode_six_columns_two_last' );

function renkon_shortcode_six_columns_three($atts, $content = null) {
   return '<div class="six-columns-three">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_three', 'renkon_shortcode_six_columns_three' );

function renkon_shortcode_six_columns_three_last($atts, $content = null) {
   return '<div class="six-columns-three last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_three_last', 'renkon_shortcode_six_columns_three_last' );

function renkon_shortcode_six_columns_four($atts, $content = null) {
   return '<div class="six-columns-four">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_four', 'renkon_shortcode_six_columns_four' );

function renkon_shortcode_six_columns_four_last($atts, $content = null) {
   return '<div class="six-columns-four last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_four_last', 'renkon_shortcode_six_columns_four_last' );

function renkon_shortcode_six_columns_five($atts, $content = null) {
   return '<div class="six-columns-five">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_five', 'renkon_shortcode_six_columns_five' );

function renkon_shortcode_six_columns_five_last($atts, $content = null) {
   return '<div class="six-columns-five last">' . renkon_remove_wpautop($content) . '</div>';
}
add_shortcode( 'six_columns_five_last', 'renkon_shortcode_six_columns_five_last' );


// Divide Text Shortcode
function renkon_shortcode_divider($atts, $content = null) {
   return '<div class="divider"></div>';
}
add_shortcode( 'divider', 'renkon_shortcode_divider' );

/*-----------------------------------------------------------------------------------*/
/* Text Highlight and Info Boxes Shortcodes
/*-----------------------------------------------------------------------------------*/

function renkon_shortcode_white_box($atts, $content = null) {
   return '<div class="white-box">' . do_shortcode( renkon_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'white_box', 'renkon_shortcode_white_box' );

function renkon_shortcode_yellow_box($atts, $content = null) {
   return '<div class="yellow-box">' . do_shortcode( renkon_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'yellow_box', 'renkon_shortcode_yellow_box' );

function renkon_shortcode_red_box($atts, $content = null) {
   return '<div class="red-box">' . do_shortcode( renkon_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'red_box', 'renkon_shortcode_red_box' );

function renkon_shortcode_blue_box($atts, $content = null) {
   return '<div class="blue-box">' . do_shortcode( renkon_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'blue_box', 'renkon_shortcode_blue_box' );

function renkon_shortcode_green_box($atts, $content = null) {
   return '<div class="green-box">' . do_shortcode( renkon_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'green_box', 'renkon_shortcode_green_box' );

function renkon_shortcode_lightgrey_box($atts, $content = null) {
   return '<div class="lightgrey-box">' . do_shortcode( renkon_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'lightgrey_box', 'renkon_shortcode_lightgrey_box' );

function renkon_shortcode_grey_box($atts, $content = null) {
   return '<div class="grey-box">' . do_shortcode( renkon_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'grey_box', 'renkon_shortcode_grey_box' );

function renkon_shortcode_dark_box($atts, $content = null) {
   return '<div class="dark-box">' . do_shortcode( renkon_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'dark_box', 'renkon_shortcode_dark_box' );

/*-----------------------------------------------------------------------------------*/
/* Buttons Shortcodes
/*-----------------------------------------------------------------------------------*/
function renkon_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
    'link'	=> '#',
    'target' => '',
    'color'	=> '',
    'size'	=> '',
	 'form'	=> '',
	 'font'	=> '',
    ), $atts));

	$color = ($color) ? ' '.$color. '-btn' : '';
	$size = ($size) ? ' '.$size. '-btn' : '';
	$form = ($form) ? ' '.$form. '-btn' : '';
	$font = ($font) ? ' '.$font. '-btn' : '';
	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<a' .$target. ' class="standard-btn' .$color.$size.$form.$font. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

    return $out;
}
add_shortcode('button', 'renkon_button');

/*-----------------------------------------------------------------------------------*/
/* Renkon Flickr Widget
/*-----------------------------------------------------------------------------------*/
class renkon_flickr extends WP_Widget {

	function renkon_flickr() {
		$widget_ops = array('description' => 'Show your Flickr preview images' , 'renkon');

		parent::WP_Widget(false, __('Renkon Flickr', 'renkon'),$widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$id = $instance['id'];
		$number = $instance['number'];
		$type = $instance['type'];
		$sorting = $instance['sorting'];
		$linktext = $instance['linktext'];
		$linkurl = $instance['linkurl'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

        <div class="flickr-badge-wrapper"><script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=<?php echo $sorting; ?>&amp;&amp;source=<?php echo $type; ?>&amp;<?php echo $type; ?>=<?php echo $id; ?>&amp;size=s"></script>
        <?php if($linktext == ''){echo '';} else {echo '<div class="flickr-bottom"><a href="'.$linkurl.'" class="flickr-link" target="_blank">'.$linktext.'</a></div>';}?>
		</div><!-- end .flickr-badge-wrapper -->

	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$title = esc_attr($instance['title']);
		$id = esc_attr($instance['id']);
		$number = esc_attr($instance['number']);
		$type = esc_attr($instance['type']);
		$sorting = esc_attr($instance['sorting']);
		$linktext = esc_attr($instance['linktext']);
		$linkurl = esc_attr($instance['linkurl']);
		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr ID (<a href="http://www.idgettr.com" target="_blank">idGettr</a>):','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" />
        </p>

       	<p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos:','renkon'); ?></label>
            <select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
                <option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Choose user or group:','renkon'); ?></label>
            <select name="<?php echo $this->get_field_name('type'); ?>" class="widefat" id="<?php echo $this->get_field_id('type'); ?>">
                <option value="user" <?php if($type == "user"){ echo "selected='selected'";} ?>><?php _e('User', 'renkon'); ?></option>
                <option value="group" <?php if($type == "group"){ echo "selected='selected'";} ?>><?php _e('Group', 'renkon'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sorting'); ?>"><?php _e('Show latest or random pictures:','renkon'); ?></label>
            <select name="<?php echo $this->get_field_name('sorting'); ?>" class="widefat" id="<?php echo $this->get_field_id('sorting'); ?>">
                <option value="latest" <?php if($sorting == "latest"){ echo "selected='selected'";} ?>><?php _e('Latest', 'renkon'); ?></option>
                <option value="random" <?php if($sorting == "random"){ echo "selected='selected'";} ?>><?php _e('Random', 'renkon'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Flickr Profile Link Text:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('linktext'); ?>" value="<?php echo $linktext; ?>" class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('linkurl'); ?>"><?php _e('Flickr Profile URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('linkurl'); ?>" value="<?php echo $linkurl; ?>" class="widefat" id="<?php echo $this->get_field_id('linkurl'); ?>" />
        </p>
		<?php
	}
}

register_widget('renkon_flickr');


/*-----------------------------------------------------------------------------------*/
/* Renkon About Widget
/*-----------------------------------------------------------------------------------*/

class renkon_about extends WP_Widget {

	function renkon_about() {
		$widget_ops = array('description' => 'About widget with picture and intro text' , 'renkon');

		parent::WP_Widget(false, __('Renkon About', 'renkon'),$widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$imageurl = $instance['imageurl'];
		$imagewidth = $instance['imagewidth'];
		$imageheight = $instance['imageheight'];
		$aboutintro = $instance['aboutintro'];
		$abouttext = $instance['abouttext'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>
			<div class="about-widget-container">
				<div class="about-img-wrap">
					<img src="<?php echo $imageurl; ?>" width="<?php echo $imagewidth; ?>" height="<?php echo $imageheight; ?>" class="about-image">
					<p class="about-intro"><?php echo $aboutintro; ?></p>
				</div><!-- end .about-img-wrap -->
				<div class="about-text-wrap">
					<?php echo $abouttext; ?>
				</div><!-- end .about-text-wrap -->
			</div><!-- end .about-widget-container -->
	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$title = esc_attr($instance['title']);
		$imageurl = esc_attr($instance['imageurl']);
		$imagewidth = esc_attr($instance['imagewidth']);
		$imageheight = esc_attr($instance['imageheight']);
		$aboutintro = esc_attr($instance['aboutintro']);
		$abouttext = esc_attr($instance['abouttext']);
		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('imageurl'); ?>"><?php _e('Image URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imageurl'); ?>" value="<?php echo $imageurl; ?>" class="widefat" id="<?php echo $this->get_field_id('imageurl'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('imagewidth'); ?>"><?php _e('Image Width (only value, no px):','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imagewidth'); ?>" value="<?php echo $imagewidth; ?>" class="widefat" id="<?php echo $this->get_field_id('imagewidth'); ?>" />
        </p>

		   <p>
            <label for="<?php echo $this->get_field_id('imageheight'); ?>"><?php _e('Image Height (only value, no px):','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imageheight'); ?>" value="<?php echo $imageheight; ?>" class="widefat" id="<?php echo $this->get_field_id('imageheight'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('aboutintro'); ?>"><?php _e('About Intro Text:','renkon'); ?></label>
           <textarea name="<?php echo $this->get_field_name('aboutintro'); ?>" class="widefat" rows="7" cols="20" id="<?php echo $this->get_field_id('aboutintro'); ?>"><?php echo( $aboutintro ); ?></textarea>
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('abouttext'); ?>"><?php _e('About Text:','renkon'); ?></label>
           <textarea name="<?php echo $this->get_field_name('abouttext'); ?>" class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('abouttext'); ?>"><?php echo( $abouttext ); ?></textarea>
        </p>

		<?php
	}
}

register_widget('renkon_about');


/*-----------------------------------------------------------------------------------*/
/* Renkon Social Links Widget
/*-----------------------------------------------------------------------------------*/

 class renkon_sociallinks extends WP_Widget {

	function renkon_sociallinks() {
		$widget_ops = array('description' => 'Link to your social profile sites' , 'renkon');

		parent::WP_Widget(false, __('Renkon Social Links', 'renkon'),$widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$googleplus = $instance['googleplus'];
		$appnet = $instance['appnet'];
		$flickr = $instance['flickr'];
		$instagram = $instance['instagram'];
		$picasa = $instance['picasa'];
		$fivehundredpx = $instance['fivehundredpx'];
		$youtube = $instance['youtube'];
		$vimeo = $instance['vimeo'];
		$dribbble = $instance['dribbble'];
		$ffffound = $instance['ffffound'];
		$pinterest = $instance['pinterest'];
		$behance = $instance['behance'];
		$deviantart = $instance['deviantart'];
		$squidoo = $instance['squidoo'];
		$slideshare = $instance['slideshare'];
		$lastfm = $instance['lastfm'];
		$grooveshark = $instance['grooveshark'];
		$soundcloud = $instance['soundcloud'];
		$foursquare = $instance['foursquare'];
		$github = $instance['github'];
		$linkedin = $instance['linkedin'];
		$xing = $instance['xing'];
		$wordpress = $instance['wordpress'];
		$tumblr = $instance['tumblr'];
		$rss = $instance['rss'];
		$rsscomments = $instance['rsscomments'];
		$target = $instance['target'];


		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

        <ul class="sociallinks">
			<?php
			if($twitter != '' && $target != ''){
				echo '<li><a href="'.$twitter.'" class="twitter" title="Twitter" target="_blank">Twitter</a></li>';
			} elseif($twitter != '') {
				echo '<li><a href="'.$twitter.'" class="twitter" title="Twitter">Twitter</a></li>';
			}
			?>

			<?php
			if($facebook != '' && $target != ''){
				echo '<li><a href="'.$facebook.'" class="facebook" title="Facebook" target="_blank">Facebook</a></li>';
			} elseif($facebook != '') {
				echo '<li><a href="'.$facebook.'" class="facebook" title="Facebook">Facebook</a></li>';
			}
			?>

			<?php
			if($googleplus != '' && $target != ''){
				echo '<li><a href="'.$googleplus.'" class="googleplus" title="Google+" target="_blank">Google+</a></li>';
			} elseif($googleplus != '') {
				echo '<li><a href="'.$googleplus.'" class="googleplus" title="Google+">Google+</a></li>';
			}
			?>

			<?php
			if($appnet != '' && $target != ''){
				echo '<li><a href="'.$appnet.'" class="appnet" title="App.net" target="_blank">App.net</a></li>';
			} elseif($appnet != '') {
				echo '<li><a href="'.$appnet.'" class="appnet" title="App.net">App.net</a></li>';
			}
			?>

			<?php if($flickr != '' && $target != ''){
				echo '<li><a href="'.$flickr.'" class="flickr" title="Flickr" target="_blank">Flickr</a></li>';
			} elseif($flickr != '') {
				echo '<li><a href="'.$flickr.'" class="flickr" title="Flickr">Flickr</a></li>';
			}
			?>

			<?php if($instagram != '' && $target != ''){
				echo '<li><a href="'.$instagram.'" class="instagram" title="Instagram" target="_blank">Instagram</a></li>';
			} elseif($instagram != '') {
				echo '<li><a href="'.$instagram.'" class="instagram" title="Instagram">Instagram</a></li>';
			}
			?>

			<?php if($picasa != '' && $target != ''){
				echo '<li><a href="'.$picasa.'" class="picasa" title="Picasa" target="_blank">Picasa</a></li>';
			} elseif($picasa != '') {
				echo '<li><a href="'.$picasa.'" class="picasa" title="Picasa">Picasa</a></li>';
			}
			?>

			<?php if($fivehundredpx != '' && $target != ''){
				echo '<li><a href="'.$fivehundredpx.'" class="fivehundredpx" title="500px" target="_blank">500px</a></li>';
			} elseif($fivehundredpx != '') {
				echo '<li><a href="'.$fivehundredpx.'" class="fivehundredpx" title="500px">500px</a></li>';
			}
			?>

			<?php if($youtube != '' && $target != ''){
			echo '<li><a href="'.$youtube.'" class="youtube" title="YouTube" target="_blank">YouTube</a></li>';
			} elseif($youtube != '') {
				echo '<li><a href="'.$youtube.'" class="youtube" title="YouTube">YouTube</a></li>';
			}
			?>

			<?php if($vimeo != '' && $target != ''){
			echo '<li><a href="'.$vimeo.'" class="vimeo" title="Vimeo" target="_blank">Vimeo</a></li>';
			} elseif($vimeo != '') {
				echo '<li><a href="'.$vimeo.'" class="vimeo" title="Vimeo">Vimeo</a></li>';
			}
			?>

			<?php if($dribbble != '' && $target != ''){
			echo '<li><a href="'.$dribbble.'" class="dribbble" title="Dribbble" target="_blank">Dribbble</a></li>';
			} elseif($dribbble != '') {
				echo '<li><a href="'.$dribbble.'" class="dribbble" title="Dribbble">Dribbble</a></li>';
			}
			?>

			<?php if($ffffound != '' && $target != ''){
			echo '<li><a href="'.$ffffound.'" class="ffffound" title="Ffffound" target="_blank">Ffffound</a></li>';
			} elseif($ffffound != '') {
				echo '<li><a href="'.$ffffound.'" class="ffffound" title="Ffffound">Ffffound</a></li>';
			}
			?>

			<?php if($pinterest != '' && $target != ''){
			echo '<li><a href="'.$pinterest.'" class="pinterest" title="Pinterest" target="_blank">Pinterest</a></li>';
			} elseif($pinterest != '') {
				echo '<li><a href="'.$pinterest.'" class="pinterest" title="Pinterest">Pinterest</a></li>';
			}
			?>

			<?php if($behance != '' && $target != ''){
				echo '<li><a href="'.$behance.'" class="behance" title="Behance Network" target="_blank">Behance Network</a></li>';
			} elseif($behance != '') {
				echo '<li><a href="'.$behance.'" class="behance" title="Behance Network">Behance Network</a></li>';
			}
			?>

			<?php if($deviantart != '' && $target != ''){
				echo '<li><a href="'.$deviantart.'" class="deviantart" title="deviantART" target="_blank">deviantART</a></li>';
			} elseif($deviantart != '') {
				echo '<li><a href="'.$deviantart.'" class="deviantart" title="deviantART">deviantART</a></li>';
			}
			?>

			<?php if($squidoo != '' && $target != ''){
				echo '<li><a href="'.$squidoo.'" class="squidoo" title="Squidoo" target="_blank">Squidoo</a></li>';
			} elseif($squidoo != '') {
				echo '<li><a href="'.$squidoo.'" class="squidoo" title="Squidoo">Squidoo</a></li>';
			}
			?>

			<?php if($slideshare != '' && $target != ''){
				echo '<li><a href="'.$slideshare.'" class="slideshare" title="Slideshare" target="_blank">Slideshare</a></li>';
			} elseif($slideshare != '') {
				echo '<li><a href="'.$slideshare.'" class="slideshare" title="Slideshare">Slideshare</a></li>';
			}
			?>

			<?php if($lastfm != '' && $target != ''){
				echo '<li><a href="'.$lastfm.'" class="lastfm" title="Lastfm" target="_blank">Lastfm</a></li>';
			} elseif($lastfm != '') {
				echo '<li><a href="'.$lastfm.'" class="lastfm" title="Lastfm">Lastfm</a></li>';
			}
			?>

			<?php if($grooveshark != '' && $target != ''){
				echo '<li><a href="'.$grooveshark.'" class="grooveshark" title="Grooveshark" target="_blank">Grooveshark</a></li>';
			} elseif($grooveshark != '') {
				echo '<li><a href="'.$grooveshark.'" class="grooveshark" title="Grooveshark">Grooveshark</a></li>';
			}
			?>

			<?php if($soundcloud != '' && $target != ''){
				echo '<li><a href="'.$soundcloud.'" class="soundcloud" title="Soundcloud" target="_blank">Soundcloud</a></li>';
			} elseif($soundcloud != '') {
				echo '<li><a href="'.$soundcloud.'" class="soundcloud" title="Soundcloud">Soundcloud</a></li>';
			}
			?>

			<?php if($foursquare != '' && $target != ''){
				echo '<li><a href="'.$foursquare.'" class="foursquare" title="Foursquare" target="_blank">Foursquare</a></li>';
			} elseif($foursquare != '') {
				echo '<li><a href="'.$foursquare.'" class="foursquare" title="Foursquare">Foursquare</a></li>';
			}
			?>

			<?php if($github != '' && $target != ''){
				echo '<li><a href="'.$github.'" class="github" title="GitHub" target="_blank">GitHub</a></li>';
			} elseif($github != '') {
				echo '<li><a href="'.$github.'" class="github" title="GitHub">GitHub</a></li>';
			}
			?>

			<?php if($linkedin != '' && $target != ''){
				echo '<li><a href="'.$linkedin.'" class="linkedin" title="LinkedIn" target="_blank">LinkedIn</a></li>';
			} elseif($linkedin != '') {
				echo '<li><a href="'.$linkedin.'" class="linkedin" title="LinkedIn">LinkedIn</a></li>';
			}
			?>

			<?php if($xing != '' && $target != ''){
				echo '<li><a href="'.$xing.'" class="xing" title="Xing" target="_blank">Xing</a></li>';
			} elseif($xing != '') {
				echo '<li><a href="'.$xing.'" class="xing" title="Xing">Xing</a></li>';
			}
			?>

			<?php if($wordpress != '' && $target != ''){
				echo '<li><a href="'.$wordpress.'" class="wordpress" title="WordPress" target="_blank">WordPress</a></li>';
			} elseif($wordpress != '') {
				echo '<li><a href="'.$wordpress.'" class="wordpress" title="WordPress">WordPress</a></li>';
			}
			?>

			<?php if($tumblr != '' && $target != ''){
				echo '<li><a href="'.$tumblr.'" class="tumblr" title="Tumblr" target="_blank">Tumblr</a></li>';
			} elseif($tumblr != '') {
				echo '<li><a href="'.$tumblr.'" class="tumblr" title="Tumblr">Tumblr</a></li>';
			}
			?>

			<?php if($rss != '' && $target != ''){
				echo '<li><a href="'.$rss.'" class="rss" title="RSS Feed" target="_blank">RSS Feed</a></li>';
			} elseif($rss != '') {
				echo '<li><a href="'.$rss.'" class="rss" title="RSS Feed">RSS Feed</a></li>';
			}
			?>

			<?php if($rsscomments != '' && $target != ''){
				echo '<li><a href="'.$rsscomments.'" class="rsscomments" title="RSS Comments" target="_blank">RSS Comments</a></li>';
			} elseif($rsscomments != '') {
				echo '<li><a href="'.$rsscomments.'" class="rsscomments" title="RSS Comments">RSS Comments</a></li>';
			}
			?>

		</ul><!-- end .sociallinks -->

	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$title = esc_attr($instance['title']);
		$twitter = esc_attr($instance['twitter']);
		$facebook = esc_attr($instance['facebook']);
		$googleplus = esc_attr($instance['googleplus']);
		$appnet = esc_attr($instance['appnet']);
		$flickr = esc_attr($instance['flickr']);
		$instagram = esc_attr($instance['instagram']);
		$picasa = esc_attr($instance['picasa']);
		$fivehundredpx = esc_attr($instance['fivehundredpx']);
		$youtube = esc_attr($instance['youtube']);
		$vimeo = esc_attr($instance['vimeo']);
		$dribbble = esc_attr($instance['dribbble']);
		$ffffound = esc_attr($instance['ffffound']);
		$pinterest = esc_attr($instance['pinterest']);
		$behance = esc_attr($instance['behance']);
		$deviantart = esc_attr($instance['deviantart']);
		$squidoo = esc_attr($instance['squidoo']);
		$slideshare = esc_attr($instance['slideshare']);
		$lastfm = esc_attr($instance['lastfm']);
		$grooveshark = esc_attr($instance['grooveshark']);
		$soundcloud = esc_attr($instance['soundcloud']);
		$foursquare = esc_attr($instance['foursquare']);
		$github = esc_attr($instance['github']);
		$linkedin = esc_attr($instance['linkedin']);
		$xing = esc_attr($instance['xing']);
		$wordpress = esc_attr($instance['wordpress']);
		$tumblr = esc_attr($instance['tumblr']);
		$rss = esc_attr($instance['rss']);
		$rsscomments = esc_attr($instance['rsscomments']);
		$target = esc_attr($instance['target']);

		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google+ URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('googleplus'); ?>" value="<?php echo $googleplus; ?>" class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('appnet'); ?>"><?php _e('App.net URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('appnet'); ?>" value="<?php echo $appnet; ?>" class="widefat" id="<?php echo $this->get_field_id('appnet'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo $flickr; ?>" class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" />
        </p>

		 <p>
            <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo $instagram; ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('picasa'); ?>"><?php _e('Picasa URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('picasa'); ?>" value="<?php echo $picasa; ?>" class="widefat" id="<?php echo $this->get_field_id('picasa'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('fivehundredpx'); ?>"><?php _e('500px URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('fivehundredpx'); ?>" value="<?php echo $fivehundredpx; ?>" class="widefat" id="<?php echo $this->get_field_id('fivehundredpx'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $youtube; ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php _e('Vimeo URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo $vimeo; ?>" class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e('Dribbble URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('dribbble'); ?>" value="<?php echo $dribbble; ?>" class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('ffffound'); ?>"><?php _e('Ffffound URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('ffffound'); ?>" value="<?php echo $ffffound; ?>" class="widefat" id="<?php echo $this->get_field_id('ffffound'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo $pinterest; ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('behance'); ?>"><?php _e('Behance Network URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('behance'); ?>" value="<?php echo $behance; ?>" class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" />
        </p>

		 <p>
            <label for="<?php echo $this->get_field_id('deviantart'); ?>"><?php _e('deviantART URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('deviantart'); ?>" value="<?php echo $deviantart; ?>" class="widefat" id="<?php echo $this->get_field_id('deviantart'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('squidoo'); ?>"><?php _e('Squidoo URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('squidoo'); ?>" value="<?php echo $squidoo; ?>" class="widefat" id="<?php echo $this->get_field_id('squidoo'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('slideshare'); ?>"><?php _e('Slideshare URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('slideshare'); ?>" value="<?php echo $slideshare; ?>" class="widefat" id="<?php echo $this->get_field_id('slideshare'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('lastfm'); ?>"><?php _e('Last.fm URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('lastfm'); ?>" value="<?php echo $lastfm; ?>" class="widefat" id="<?php echo $this->get_field_id('lastfm'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('grooveshark'); ?>"><?php _e('Grooveshark URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('grooveshark'); ?>" value="<?php echo $grooveshark; ?>" class="widefat" id="<?php echo $this->get_field_id('grooveshark'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php _e('Soundcloud URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('soundcloud'); ?>" value="<?php echo $soundcloud; ?>" class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php _e('Foursquare URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('foursquare'); ?>" value="<?php echo $foursquare; ?>" class="widefat" id="<?php echo $this->get_field_id('foursquare'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('github'); ?>"><?php _e('GitHub URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('github'); ?>" value="<?php echo $github; ?>" class="widefat" id="<?php echo $this->get_field_id('github'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo $linkedin; ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('xing'); ?>"><?php _e('Xing URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('xing'); ?>" value="<?php echo $xing; ?>" class="widefat" id="<?php echo $this->get_field_id('xing'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('wordpress'); ?>"><?php _e('WordPress URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('wordpress'); ?>" value="<?php echo $wordpress; ?>" class="widefat" id="<?php echo $this->get_field_id('wordpress'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e('Tumblr URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('tumblr'); ?>" value="<?php echo $tumblr; ?>" class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS-Feed URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo $rss; ?>" class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('rsscomments'); ?>"><?php _e('RSS for Comments URL:','renkon'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('rsscomments'); ?>" value="<?php echo $rsscomments; ?>" class="widefat" id="<?php echo $this->get_field_id('rsscomments'); ?>" />
        </p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['target'], true ); ?> id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" <?php checked( $target, 'on' ); ?>> <?php _e('Open all links in a new browser tab', 'renkon'); ?></input>
		</p>

		<?php
	}
}

register_widget('renkon_sociallinks');?>
<?php 
//loads products home

add_action('wp_ajax_cargaPortfolio', 'cargaPortfolio');
add_action('wp_ajax_nopriv_cargaPortfolio', 'cargaPortfolio');

function cargaPortfolio(){?>
	<?php $artista = $_GET['artista']?>
    <?php $disciplina = $_GET['disciplina'] ?>
    <?php $tipo = $_GET['tipo'] ?>
	
   
    <?php $ps = get_posts(array('post_type' => 'post' , 'numberposts' => -1 , 'tipo' => $tipo ,'disciplina' => $disciplina , 'artistas' => $artista))?>
    <?php foreach($ps as $p):?>
		
        
        
        <?php $options = get_option('renkon_theme_options'); ?>

<?php $disciplinas = wp_get_post_terms( $p->ID, 'disciplina' )?>
<?php $artistas = wp_get_post_terms( $p->ID, 'artistas' )?>
<?php $tipos = wp_get_post_terms( $p->ID, 'tipo' )?>


<article id="post-<?php $p->ID; ?>" <?php //post_class('postblog'); ?> class="postblog post <?php echo 'at-'.$artistas[0]->term_id;?> <?php echo 'pd-'.$disciplinas[0]->term_id;?> <?php echo 'td-'.$tipos[0]->term_id;?>">
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php echo get_permalink($p->ID); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'renkon' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>	<h3 class="entry-title"><?php echo $artistas[0]->name ?></h3>	
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

		<?php //if ( has_post_thumbnail() ) {
		echo '<a href="'; the_permalink(); echo '" class="thumb">';
		echo get_the_post_thumbnail($p->ID , 'thumbnail');
		echo '</a>';
		//} ?>            

</article>
        
        
    <?php endforeach;?>

<?php die();}?>