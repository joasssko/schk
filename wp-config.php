<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'schkolnick');

/** MySQL database username */
define('DB_USER', 'schkolnick');

/** MySQL database password */
define('DB_PASSWORD', 'schkolnick9876.,');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'lQ-A<yLwp4r!DIc?JLs9_<< A49s/~*|]hM`+*.i#;g: _s3<e!s/U([<<;N%A]b');
define('SECURE_AUTH_KEY',  'm:|}mdy^!tYU3O06ug@M?lev?yZK@1zzIQK+h5l%5e%|nvf|1SQ9-]s+k#oFnEvI');
define('LOGGED_IN_KEY',    '+w1)B4ah~B&*2!SHG `nE=giU&+w$(?<Sf$WKi-hB <!%G@:S!m)K2+?Aa8X)JLh');
define('NONCE_KEY',        '2cV|OXUgzXqm+y.4 c9v{tq,=vYcLLJ/~3h|C?I:9PvV;F k:4lhu|#)x$Seq~W^');
define('AUTH_SALT',        'CLI`4>n];R_G^eq{fqA{c{U^0CmOdf[G{?J,F})IX^kQ$4/*h:h_[-H!9v29jfz7');
define('SECURE_AUTH_SALT', '!KYwok_0|Jx=9r%ERLb$hXI#`7S>uSNp!)X[sr]$sxK3y|x>;MvkC?On%7yv7~S}');
define('LOGGED_IN_SALT',   'Qu8s:jT4zK2~%-SWI-Ee8-%OcB-(q<Tph>Lo`G Re45j#7SlS^jV0k#O.&SH:sDe');
define('NONCE_SALT',       'T/{ C ?vkO#y^,^V0B:x=ya}GDMS|p@x1nJfFm|&BC!QkjhY-dTQ>VWyj%#T{G`Q');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to Canadian English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * en_CA.mo to wp-content/languages and set WPLANG to 'en_CA' to enable Canadian
 * English language support.
 */
define('WPLANG', 'en_CA');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
