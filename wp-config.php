<?php
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
define( 'DB_NAME', 'tymesdata' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'd3*%<7BW:-EG^damACo;s<k-M~(4)v<&b9!6M?r%~[(lclIrY;uunBy%XWajkLp#' );
define( 'SECURE_AUTH_KEY',  '8]@P=:54?uN{)o+]kwpPXm|N)VsI,aUa/o5y ^UFwX)ezZA^-b.g:.a3UX+ +4_!' );
define( 'LOGGED_IN_KEY',    'nn|)ar+_wB?<IuSRs|HRi|Rag+F/`6ybK4ML70Qvj{:$`>Tm6)*oR$HYfC~|bI]!' );
define( 'NONCE_KEY',        '0ijx8Z`2+Nu.,=Q.9S-b c#bk0`g.U0~HFQ7FR[@ ?&cq~4;O.C{YJEb2yB_:YQ-' );
define( 'AUTH_SALT',        '>Alm c2oODB+o#!I.|W`qvo}N1WZx4{PF`*[eIT,BQd4Wr/@-!^l<ks~5tRiABD>' );
define( 'SECURE_AUTH_SALT', 'ab|6ykS;Shb~6h<Bcr|:!4@}NC;>:ldVJdX=T``K?f<e.|v`(8M0^hKoX3Kno]%8' );
define( 'LOGGED_IN_SALT',   'W/`vzm#-ZG2K-28f9i@}@n<kc]nL#A,3c!Heo#YXZ>?pn8^|,nECrok`aTCR[j4r' );
define( 'NONCE_SALT',       '4E0A/T&H`]!T($&7;/1]Xp*e*JKu4ZDNl@aIN&2lh,Fhe^*#>k kz8:[I(dkR{)`' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
