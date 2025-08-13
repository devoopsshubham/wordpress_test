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

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp4458_nexgenwebz_com_mM1OzDBh' );

/** Database username */
define( 'DB_USER', 'wp4458nexgenpEAq' );

/** Database password */
define( 'DB_PASSWORD', 'V2rma8YifSN9kseXU4H36Gy5' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'd{HH-;hswLn513FHzVnZO/|x1{&Ngq^?vW1Y1*/Tm=V]w{a_~6jpW%QQ[^^Q>K0O' );
define( 'SECURE_AUTH_KEY',   'lV=LAgu)qe|Z`UCO#B:wJsm~ekek7H0sID`UHK&u HKfGr)m,{N}tla,c!@f(/Vk' );
define( 'LOGGED_IN_KEY',     'vV?l {k~(xeoXtl:G$Td|?h!|VF6}_Rv8w[&&}mbeZ~K&F-doR]h8IDeOgzusiv2' );
define( 'NONCE_KEY',         'U~5oqIW]FJ~:dY_+![8%47x2?,efOAF)9S=(;Q|!r,FJuzk+JWla44@F<|!_X]gX' );
define( 'AUTH_SALT',         'h;:XC_JJH?q(FMW2Act42HbnTxW9sK:]fkFk5Jd0%i,p%KcTJV`27dMZ@.(2*neh' );
define( 'SECURE_AUTH_SALT',  'TVsZz(^`+zP>Wr(bae`)+&iR*IJj9/5Fe$*cA#lbJwK(B]O+gf&_|OR4-(}Yo7r:' );
define( 'LOGGED_IN_SALT',    '>U1W_Yx0sC,zvfIZ`~>B&w2uIas}!u>(-@[Q+;E$5Wfy3Bvmn8ltxX+&?Wz0(fOV' );
define( 'NONCE_SALT',        'E-fm!fa)&6F:&a?rAb7RE/vW5Y[yI=^,h.$rf>jcajNe6/0@lT(ExP{<>OCSz0.[' );
define( 'WP_CACHE_KEY_SALT', '9}&,z<r`M3[?~yd}Vb0`QPP8Uur{t%W7b/#?^m@{7o4Y{r+_6Zjoenxl:Se*Y]&7' );


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
	define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true );
            define( 'WP_DEBUG_DISPLAY', true );
}

define( 'WP_REDIS_PREFIX', 'wp4458.nexgenwebz.com:' );
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
define( 'CONCATENATE_SCRIPTS', false );
define( 'WP_POST_REVISIONS', '10' );
define( 'MEDIA_TRASH', true );
define( 'EMPTY_TRASH_DAYS', '15' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
define( 'WP_REDIS_DISABLE_BANNERS', true );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
