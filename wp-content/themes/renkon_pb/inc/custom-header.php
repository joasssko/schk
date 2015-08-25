<?php
/**
 * Implements an optional custom header
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

function renkon_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 1440,
		'height'                 => 900,
		'flex-width'             => false,
		'flex-height'            => true,
		'header-text'            => false,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => 'renkon_admin_header_style',
		'admin-preview-callback' => 'renkon_admin_header_image',
	);

	
	add_theme_support( 'custom-header', $args );
	
	/*
	 * Default custom headers packaged with the theme.
	 * %s is a placeholder for the theme template directory URI.
	 */
	register_default_headers( array(
		'mountains' => array(
			'url'           => '%s/images/headers/mountains.jpg',
			'thumbnail_url' => '%s/images/headers/mountains-thumb.jpg',
			'description'   => _x( 'Mountains', 'header image description', 'renkon' )
		),
		'bread' => array(
			'url'           => '%s/images/headers/bread.jpg',
			'thumbnail_url' => '%s/images/headers/bread-thumb.jpg',
			'description'   => _x( 'Bread', 'header image description', 'renkon' )
		),
		'grapefruit' => array(
			'url'           => '%s/images/headers/grapefruit.jpg',
			'thumbnail_url' => '%s/images/headers/grapefruit-thumb.jpg',
			'description'   => _x( 'Grapefruit', 'header image description', 'renkon' )
		),
	) );

}
add_action( 'after_setup_theme', 'renkon_custom_header_setup' );


/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 */
function renkon_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	</style>
<?php
}

/**
 * Outputs markup to be displayed on the Appearance > Header admin panel.
 * This callback overrides the default markup displayed there.
 */
function renkon_admin_header_image() {
	?>
	<div id="headimg">
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }