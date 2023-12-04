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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

if(strstr($_SERVER['SERVER_NAME'], 'fictional-university.local')) {
  define( 'DB_NAME', 'local' );
  define( 'DB_USER', 'root' );
  define( 'DB_PASSWORD', 'root' );
  define( 'DB_HOST', 'localhost' );  
} else {
  // define( 'DB_NAME', 'local' );
  // define( 'DB_USER', 'root' );
  // define( 'DB_PASSWORD', 'root' );
  // define( 'DB_HOST', 'localhost' );  
}


/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'Np|+!38b.zP+z[04WD_f7N13PycU-&I/Nsb3Y[/j:|ndyR0I7OEEL!+)uK`j`asH' );
define( 'SECURE_AUTH_KEY',   'PwNP`;%;7sR#(PA`aJgWUqxHk3k[sO1[qhdjc;:m1:mxpC:8e#cGaEac*MDqkCy2' );
define( 'LOGGED_IN_KEY',     '|.Lp/&h<1uv*-3+)Y&bkMLwvkC=P&G6!pon]ejO3$ ?R&_XUG7<wjQJy1kyew02Q' );
define( 'NONCE_KEY',         '.? nYv9.Y{V.I8k&`-1F$>]UwdPh/;z>{h:bZl:|a]0V Ax]vKI5i1{~:THN*(Id' );
define( 'AUTH_SALT',         'MGE?6j<7<) KnBrANUf-hIzRLGpN<>&o6{iBtin$06ZNDji 44o~NiWtE`lAcYqB' );
define( 'SECURE_AUTH_SALT',  'C0uIFvPf8x==D7QPbDen.,Z,EVtn}9kRXvjT!<8Q:LWeuU~bK8~++{9XCLHAN3TD' );
define( 'LOGGED_IN_SALT',    'xdRYM6GlV:M?x=Gpqx<q X:FlB6#8g,[2vD+kcn)KnPa)A;w?i4ml:rD!g@pKy(0' );
define( 'NONCE_SALT',        '0t4jgHVUq;G<^uGZAg$=:r k?P}!vW-ZS(ff;#11r3nPyrsTe]$DS;MWq:cTP!4v' );
define( 'WP_CACHE_KEY_SALT', 'ZF}%9IwPH~090TYHh2Ovi))ZQ>p6O:1V~7iH$*%s4brKf>AGQhTiD5U[6:toeyv0' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
