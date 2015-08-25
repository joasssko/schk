<?php
/**
 * renkon Theme Options
 *
 * @subpackage Renkon
 * @since renkon 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Properly enqueue styles and scripts for our theme options page.
/*
/* This function is attached to the admin_enqueue_scripts action hook.
/*
/* @param string $hook_suffix The action passes the current page to the function.
/* We don't do anything if we're not on our theme options page.
/*-----------------------------------------------------------------------------------*/

function renkon_admin_enqueue_scripts( $hook_suffix ) {
	if ( $hook_suffix != 'appearance_page_theme_options' )
		return;

	wp_enqueue_style( 'renkon-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2013-03-05' );
	wp_enqueue_script( 'renkon-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2013-03-05' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_enqueue_scripts', 'renkon_admin_enqueue_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Register the form setting for our renkon_options array.
/*
/* This function is attached to the admin_init action hook.
/*
/* This call to register_setting() registers a validation callback, renkon_theme_options_validate(),
/* which is used when the option is saved, to ensure that our option values are complete, properly
/* formatted, and safe.
/*
/* We also use this function to add our theme option if it doesn't already exist.
/*-----------------------------------------------------------------------------------*/

function renkon_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === renkon_get_theme_options() )
		add_option( 'renkon_theme_options', renkon_get_default_theme_options() );

	register_setting(
		'renkon_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'renkon_theme_options', // Database option, see renkon_get_theme_options()
		'renkon_theme_options_validate' // The sanitization callback, see renkon_theme_options_validate()
	);
}
add_action( 'admin_init', 'renkon_theme_options_init' );

/*-----------------------------------------------------------------------------------*/
/* Add our theme options page to the admin menu.
/*
/* This function is attached to the admin_menu action hook.
/*-----------------------------------------------------------------------------------*/

function renkon_theme_options_add_page() {
	add_theme_page(
		__( 'Theme Options', 'renkon' ), // Name of page
		__( 'Theme Options', 'renkon' ), // Label in menu
		'edit_theme_options',                  // Capability required
		'theme_options',                       // Menu slug, used to uniquely identify the page
		'theme_options_render_page'            // Function that renders the options page
	);
}
add_action( 'admin_menu', 'renkon_theme_options_add_page' );

/*-----------------------------------------------------------------------------------*/
/* Returns an array of header image color options for Renkon
/*-----------------------------------------------------------------------------------*/
function renkon_headercolor() {
	$headercolor_options = array(
		'headercolor-white' => array(
			'value' => 'headercolor-white',
			'label' => __( 'White Header Font Color', 'renkon' ),
		),
		'headercolor-black' => array(
			'value' => 'headercolor-black',
			'label' => __( 'Black Header Font Color', 'renkon' ),
		),
	);

	return apply_filters( 'renkon_headercolor', $headercolor_options );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the default options for Renkon
/*-----------------------------------------------------------------------------------*/

function renkon_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   => '#f98667',
		'mainbg_color'   => '#ffffff',
		'theme_headercolor' => 'headercolor-white',
		'header-slogan' => '',
		'header-subtitle' => '',
		'featured_cat' => '',
		'custom_logo' => '',
		'custom_footertext' => '',
		'custom_authorlinks' => '',
		'custom_favicon' => '',
		'custom_apple_icon' => '',
		'show-excerpt' => '',
		'share-posts' => '',
		'share-singleposts' => '',
		'share-pages' => '',
		'inf_scroll' => '',
		'custom-css' => '',
	);

	return apply_filters( 'renkon_default_theme_options', $default_theme_options );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for renkon
/*-----------------------------------------------------------------------------------*/

function renkon_get_theme_options() {
	return get_option( 'renkon_theme_options' );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for renkon
/*-----------------------------------------------------------------------------------*/

function theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'renkon' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'renkon_options' );
				$options = renkon_get_theme_options();
				$default_options = renkon_get_default_theme_options();
			?>

			<table class="form-table">
			<h3 style="margin-top:30px;"><?php _e( 'Custom Colors', 'renkon' ); ?></h3>
				<tr valign="top"><th scope="row"><?php _e( 'Link Color', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'renkon' ); ?></span></legend>
							 <input type="text" name="renkon_theme_options[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>" id="link-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker1"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your custom link color, the default color is: %s. (Do not forget to include the # before the color value.)', 'renkon' ), $default_options['link_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Main Background Color', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Main Background Color', 'renkon' ); ?></span></legend>
							 <input type="text" name="renkon_theme_options[mainbg_color]" value="<?php echo esc_attr( $options['mainbg_color'] ); ?>" id="mainbg-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker3"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose a custom background color, the default color is: %s.', 'renkon' ), $default_options['mainbg_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>
				</table>

				<table class="form-table">
				<h3 style="margin-top:30px;"><?php _e( 'Header Image Slogan', 'renkon' ); ?></h3>
				<tr valign="top"><th scope="row"><?php _e( 'Header Slogan Text', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Header Slogan Text', 'renkon' ); ?></span></legend>
							<textarea id="renkon_theme_options[header-slogan]" class="small-text" cols="100" rows="1" name="renkon_theme_options[header-slogan]"><?php echo esc_textarea( $options['header-slogan'] ); ?></textarea>
						<br/><label class="description" for="renkon_theme_options[header-slogan]"><?php _e( 'Add a custom header slogan text. (Standard HTML is allowed).', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Header Slogan Subtitle', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Header Slogan Subtitle', 'renkon' ); ?></span></legend>
							<textarea id="renkon_theme_options[header-subtitle]" class="small-text" cols="100" rows="1" name="renkon_theme_options[header-subtitle]"><?php echo esc_textarea( $options['header-subtitle'] ); ?></textarea>
						<br/><label class="description" for="renkon_theme_options[header-subtitle]"><?php _e( 'Add a custom header subtitle text below your header slogan. (Standard HTML is allowed).', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top" class="radio-option"><th scope="row"><?php _e( 'Header Font Color', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Header Font Color', 'renkon' ); ?></span></legend>
						<?php
							foreach ( renkon_headercolor() as $headercolor ) {
								?>
								<div class="layout">
								<label class="description">
									<input type="radio" name="renkon_theme_options[theme_headercolor]" value="<?php echo esc_attr( $headercolor['value'] ); ?>" <?php checked( $options['theme_headercolor'], $headercolor['value'] ); ?> />
									<span>
										<?php echo $headercolor['label']; ?>
									</span>
								</label>
								</div>
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>
				</table>

				<table class="form-table">
				<h3 style="margin-top:30px;"><?php _e( 'Big Thumbnails, Logo, Post Excerpts & Custom Texts', 'renkon' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Post with big Thumbnails', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Post with big Thumbnails', 'renkon' ); ?></span></legend>
							<input class="regular-text" type="text" name="renkon_theme_options[featured_cat]" value="<?php echo esc_attr( $options['featured_cat'] ); ?>" />
							<br/><label class="description" for="renkon_theme_options[featured_cat]"><?php _e( 'Type in the category slug you want to use as your featured category. The default category slug is "featured". All posts of this category will have <strong>bigger thumbnails on the blog homepage</strong>. (For slug names see: Posts / Categories).', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Logo', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Logo image', 'renkon' ); ?></span></legend>
							<input class="regular-text" type="text" name="renkon_theme_options[custom_logo]" value="<?php echo esc_attr( $options['custom_logo'] ); ?>" />
						<br/><label class="description" for="renkon_theme_options[custom_logo]"><?php _e('Upload your own logo image using the ', 'renkon'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'renkon'); ?></a><?php _e('. Then copy your logo image file URL and insert the URL here.', 'renkon'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Post Excerpts', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Post Excerpts', 'renkon' ); ?></span></legend>
							<input id="renkon_theme_options[show-excerpt]" name="renkon_theme_options[show-excerpt]" type="checkbox" value="1" <?php checked( '1', $options['show-excerpt'] ); ?> />
							<label class="description" for="renkon_theme_options[show-excerpt]"><?php _e( 'Check this box to show automatic post excerpts. With this option you will not need to add the more tag in posts.', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Footer Text', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Footer text', 'renkon' ); ?></span></legend>
							<textarea id="renkon_theme_options[custom_footertext]" class="small-text" cols="100" rows="2" name="renkon_theme_options[custom_footertext]"><?php echo esc_textarea( $options['custom_footertext'] ); ?></textarea>
						<br/><label class="description" for="renkon_theme_options[custom_footertext]"><?php _e( 'Customize the footer credit text (Standard HTML is allowed).', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Author Links', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Author Links', 'renkon' ); ?></span></legend>
							<textarea id="renkon_theme_options[custom_authorlinks]" class="small-text" cols="100" rows="2" name="renkon_theme_options[custom_authorlinks]"><?php echo esc_textarea( $options['custom_authorlinks'] ); ?></textarea>
						<br/><label class="description" for="renkon_theme_options[custom_authorlinks]"><?php _e( 'Add custom "Find me on" links to your author bio on single posts (Standard HTML is allowed).', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>
				</table>

				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Favicon and Apple Touch Icon', 'renkon' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Favicon', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Favicon', 'renkon' ); ?></span></legend>
							<input class="regular-text" type="text" name="renkon_theme_options[custom_favicon]" value="<?php echo esc_attr( $options['custom_favicon'] ); ?>" />
						<br/><label class="description" for="renkon_theme_options[custom_favicon]"><?php _e( 'Create a <strong>16x16px</strong> image and generate a .ico favicon using a favicon online generator. Now upload your favicon to your themes folder (via FTP) and enter your Favicon URL here (the URL path should be similar to: yourdomain.com/wp-content/themes/renkon/favicon.ico).', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Apple Touch Icon', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Apple Touch Icon', 'renkon' ); ?></span></legend>
							<input class="regular-text" type="text" name="renkon_theme_options[custom_apple_icon]" value="<?php echo esc_attr( $options['custom_apple_icon'] ); ?>" />
						<br/><label class="description" for="renkon_theme_options[custom_apple_icon]"><?php _e('Create a <strong>128x128px png</strong> image for your webclip icon. Upload your image using the ', 'renkon'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'renkon'); ?></a><?php _e('. Now copy the image file URL and insert the URL here.', 'renkon'); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>

				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Share Buttons for Posts and Pages', 'renkon' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Share Buttons on Posts', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share Buttons on Posts', 'renkon' ); ?></span></legend>
							<input id="renkon_theme_options[share-posts]" name="renkon_theme_options[share-posts]" type="checkbox" value="1" <?php checked( '1', $options['share-posts'] ); ?> />
							<label class="description" for="renkon_theme_options[share-posts]"><?php _e( 'Check this box to show share buttons (Twitter, Facebook, Google+, Pinterest) on single posts.', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share Buttons on Pages', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share Buttons on Pages', 'renkon' ); ?></span></legend>
							<input id="renkon_theme_options[share-pages]" name="renkon_theme_options[share-pages]" type="checkbox" value="1" <?php checked( '1', $options['share-pages'] ); ?> />
							<label class="description" for="renkon_theme_options[share-pages]"><?php _e( 'Check this box to show share buttons on pages.', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>

				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Infinite Scroll', 'renkon' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Infinite Scroll Pagination', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Infinite Scroll Pagination', 'renkon' ); ?></span></legend>

						<input id="renkon_theme_options[inf_scroll]" name="renkon_theme_options[inf_scroll]" type="checkbox" value="1" <?php checked( '1', $options['inf_scroll'] ); ?> />


							<label class="description" for="renkon_theme_options[inf_scroll]"><?php _e( 'Check this box to activate Infinite Scroll pagination.', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>

				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Custom CSS', 'renkon' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Include Custom CSS', 'renkon' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Include Custom CSS', 'renkon' ); ?></span></legend>
							<textarea id="renkon_theme_options[custom-css]" class="small-text" style="font-family: monospace;" cols="100" rows="10" name="renkon_theme_options[custom-css]"><?php echo esc_textarea( $options['custom-css'] ); ?></textarea>
						<br/><label class="description" for="renkon_theme_options[custom-css]"><?php _e( 'Include custom CSS styles, use !important to overwrite existing styles.', 'renkon' ); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Sanitize and validate form input. Accepts an array, return a sanitized array.
/*-----------------------------------------------------------------------------------*/

function renkon_theme_options_validate( $input ) {
	global $layout_options, $font_options;

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
			$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Link hover color must be 3 or 6 hexadecimal characters
	if ( isset( $input['mainbg_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['mainbg_color'] ) )
			$output['mainbg_color'] = '#' . strtolower( ltrim( $input['mainbg_color'], '#' ) );

	// Header Font colors must be in our array of theme header color options
	if ( isset( $input['theme_headercolor'] ) && array_key_exists( $input['theme_headercolor'], renkon_headercolor() ) )
		$output['theme_headercolor'] = $input['theme_headercolor'];

	// Text options must be safe text with no HTML tags
	$input['custom_logo'] = wp_filter_nohtml_kses( $input['custom_logo'] );
	$input['custom_favicon'] = wp_filter_nohtml_kses( $input['custom_favicon'] );
	$input['custom_apple_icon'] = wp_filter_nohtml_kses( $input['custom_apple_icon'] );
	$input['featured_cat'] = wp_filter_nohtml_kses( $input['featured_cat'] );

	// checkbox values are either 0 or 1
	if ( ! isset( $input['share-posts'] ) )
		$input['share-posts'] = null;
	$input['share-posts'] = ( $input['share-posts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-singleposts'] ) )
		$input['share-singleposts'] = null;
	$input['share-singleposts'] = ( $input['share-singleposts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-pages'] ) )
		$input['share-pages'] = null;
	$input['share-pages'] = ( $input['share-pages'] == 1 ? 1 : 0 );

	if ( ! isset( $input['inf_scroll'] ) )
		$input['inf_scroll'] = null;
	$input['inf_scroll'] = ( $input['inf_scroll'] == 1 ? 1 : 0 );

	if ( ! isset( $input['show-excerpt'] ) )
		$input['show-excerpt'] = null;
	$input['show-excerpt'] = ( $input['show-excerpt'] == 1 ? 1 : 0 );

	return $input;
}

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current link color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function renkon_print_link_color_style() {
	$options = renkon_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = renkon_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
<style type="text/css">
/* Custom Link Color */
a,
.entry-header h2.entry-title a:hover,
.overlay .entry-header h2.entry-title a:hover,
.widget_renkon_about p.about-intro a,
.secondary .widget_renkon_about .about-text-wrap a:hover,
.widget_recent_comments ul#recentcomments a:hover,
.widget_recent_entries ul a:hover,
.widget_calendar a:hover,
.widget_rss a:hover,
.widget_twitter ul.tweets a:hover,
#comments .bypostauthor .comment-content ul li.comment-author a {
	color: <?php echo $link_color; ?>
}
.secondary .widget_categories ul li a:hover,
.flickr-badge-wrapper a:hover img,
#infscr-loading {
	border: 2px solid <?php echo $link_color; ?>;
}
.entry-content a.more-link:hover {
	border-bottom: 1px solid <?php echo $link_color; ?>;
}
.entry-content a.more-link:hover,
.header-inner .header-slogan a:hover,
.header-inner .header-subtitle a:hover,
.secondary .widget_categories ul li a:hover,
ul.sociallinks li,
.widget_renkon_flickr .flickr-bottom a.flickr-link:hover,
input#submit:hover,
input.wpcf7-submit:hover,
input[type="submit"],
.entry-content .archive-tags a:hover,
.flickr_badge_wrapper .flickr-bottom a,
input[type="submit"] {
	background: <?php echo $link_color; ?>;
}
</style>
<?php
}
add_action( 'wp_head', 'renkon_print_link_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the main background color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function renkon_print_mainbg_color_style() {
	$options = renkon_get_theme_options();
	$mainbg_color = $options['mainbg_color'];

	$default_options = renkon_get_default_theme_options();

	// Don't do anything if the current  optional font color is the default.
	if ( $default_options['mainbg_color'] == $mainbg_color )
		return;
?>
<style type="text/css">
/* Custom Background Color */
body,
.active-sidebar #content-wrap,
.active-sidebar .column-wrap {background: <?php echo $mainbg_color; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'renkon_print_mainbg_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current header font color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function renkon_print_theme_headercolor_style() {
	$options = renkon_get_theme_options();
	$theme_headercolor = $options['theme_headercolor'];

	$default_options = renkon_get_default_theme_options();

	// Don't do anything if the current headercolor color is the default.
	if ( $default_options['theme_headercolor'] == $theme_headercolor )
		return;
?>
<style type="text/css">
/* Custom Header Image Font Color */
.header-inner, .header-inner a:hover {color:#000;}
@media screen and (min-width: 1280px) {
.header-btn {background: url(<?php echo get_template_directory_uri(); ?>/images/header-btn-dark.png) -1px -1px no-repeat;}
}
@media only screen and (-moz-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min-device-pixel-ratio: 1.5) {
.header-btn {background: url(<?php echo get_template_directory_uri(); ?>/images/x2/header-btn-dark.png) -1px -1px no-repeat; background-size: 67px 67px;}
}
</style>
<?php
}
add_action( 'wp_head', 'renkon_print_theme_headercolor_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for category with big thumbnail sizes.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function renkon_print_featured_cat_style() {
	$options = renkon_get_theme_options();
	$featured_cat = $options['featured_cat'];

	$default_options = renkon_get_default_theme_options();

	// Don't do anything if the current  optional font color is the default.
	if ( $default_options['featured_cat'] == $featured_cat )
		return;
?>
<style type="text/css">
/* Featured Cat Thumbnail Sizes */
@media screen and (min-width: 1024px) {
div#site-content article.category-<?php echo $featured_cat; ?> {width: 45.2%;}
}
@media screen and (min-width: 1280px) {
div#site-content article.category-<?php echo $featured_cat; ?> {width: 31.2%;}
}
@media screen and (min-width: 1400px) {
div#site-content article.category-<?php echo $featured_cat; ?> {width: 32.2%;}
}
@media screen and (min-width: 1800px) {
div#site-content article.category-<?php echo $featured_cat; ?> {width: 32.2%;}
}
@media screen and (min-width: 2400px) {
div#site-content article.category-<?php echo $featured_cat; ?> {width: 32.2%;}
}

</style>
<?php
}
add_action( 'wp_head', 'renkon_print_featured_cat_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for custom css styles.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function renkon_print_customcss_style() {
	$options = renkon_get_theme_options();
	$customcss = $options['custom-css'];

	$default_options = renkon_get_default_theme_options();

	// Don't do anything if the current  footer widget background color is the default.
	if ( $default_options['custom-css'] == $customcss )
		return;
?>
<style type="text/css">
/* Custom CSS */
<?php echo $customcss; ?>
</style>
<?php
}
add_action( 'wp_head', 'renkon_print_customcss_style' );

/*-----------------------------------------------------------------------------------*/
/* Add Infinte Scroll Script if activated.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function renkon_print_infscroll_style() {
	$options = renkon_get_theme_options();
	$infscroll = $options['inf_scroll'];

	$default_options = renkon_get_default_theme_options();

	// Don't do anything if the current  footer widget background color is the default.
	if ( $default_options['inf_scroll'] == $infscroll )
		return;
?>
<style type="text/css">
/* Additional CSS for Infinite Scroll */
.colophon {padding-bottom: 50px !important;}
#nav-below {display: none;}
</style>
<?php
}
add_action( 'wp_head', 'renkon_print_infscroll_style' );

