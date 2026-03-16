<?php
define('WP_CACHE', false); // Added by WP Rocket

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wwimpo_deka77ultimo' );

/** Database username */
define( 'DB_USER', 'wwimpo_deka77ultimo' );

/** Database password */
define( 'DB_PASSWORD', 'wwimpo_deka77ultimo' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'G<6bHlK)M*I<i1WUU$3D[|u}soCwvvBy( f-og%x%OH/RR@@GK<q,hw#,JY$9mYc' );
define( 'SECURE_AUTH_KEY',  'X!v|`T,c2[%22d|r=Zd&hK*4*4o(&B~#6+X)057@Y,6VwA,3w3+iEZEnPP_jEz1<' );
define( 'LOGGED_IN_KEY',    '{r[4]Gmg`AHA)ti=f/:SeaWuP<u] /.cg!G!uGUeCqTv^Pd(_?|~#vE<}&Wm??+%' );
define( 'NONCE_KEY',        ';;5TsbOUZ}9C[wj:3_gK14,g,V}}`UgCULKOMEv6eq`8h-tDd?}#|WsF4UTgr>`*' );
define( 'AUTH_SALT',        'tQ9(}*RQd#&-Jg[O.nZ_G/C!x)UF9l i9Eb,!v#tKIVVe:MXf/qRe&#cR!UB-cc5' );
define( 'SECURE_AUTH_SALT', '<i?V{;i]r)i}-*Wri_qME@#{yCxtjt|;]B&AyAt Q~U -~lrY~&x<(?@EStA+oh#' );
define( 'LOGGED_IN_SALT',   '`&0#AYbqx*7SrVyY!R1]. 3`7&joks5Tp[8?-!L/_Y [uWD:&ef9 mG`B4J.E:6H' );
define( 'NONCE_SALT',       'cMo&3$18rY~ioRio`~G1i&:p1ri4aLL7UaxbWfI<Ps`IknFKn!M?5W[#,+8)P@k3' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */
define( 'FORCE_SSL_ADMIN', true );

// --- Security Hardening ---
// Disable file editing from WordPress admin (prevents malicious code injection)
define( 'DISALLOW_FILE_EDIT', true );

// Disable unfiltered uploads (prevents uploading dangerous file types)
define( 'DISALLOW_UNFILTERED_UPLOADS', true );

// Limit post revisions to reduce database bloat
define( 'WP_POST_REVISIONS', 5 );

// Block external HTTP requests except to trusted hosts (prevents phone-home malware)
// Uncomment below if you want to restrict all external requests:
// define( 'WP_HTTP_BLOCK_EXTERNAL', true );
// define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,downloads.wordpress.org,*.github.com' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
