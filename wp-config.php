<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'fbag1' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );



/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '3G$9mcR::cC`gYM,mgUAH187zCx*ZCCcf$iXrRjM?9goSg(`Wza,k#g5rDX4A$Hl' );
define( 'SECURE_AUTH_KEY',  'rOwW7#q];n;--Ql$B[q*1mvgD2g`~??!S_!]`Y!@](wM#d 94iiIDl|X=D7.TRKc' );
define( 'LOGGED_IN_KEY',    ':J8ehp+K-]?w.gh<~O?]p_=eq};V_RJmKfH0Xn)y5McD~bS0,C2rqxjHYEiNWP`0' );
define( 'NONCE_KEY',        'v(s9a GZR>9q/k9!gvI#6}$>TUJ#,tX/xgR]!CnV45l|Nlr[<z*h[Oh 2J>J#b;K' );
define( 'AUTH_SALT',        '+u+zxgyq__#k#{uqF]*ek@FKb!Wv!Da>^=6|iE{o;JhALvfN u^ioW4+Yx,WErzK' );
define( 'SECURE_AUTH_SALT', 'NlbDiJ% k:=rY=n,Fee(s/~Q<PMO&|>`<, UCT1H?5]`dNuUJ>uyLMm`&3CUFOD|' );
define( 'LOGGED_IN_SALT',   'c?@>:`|ek<W7bU:>F4n fy0_ON!4wUsuhQ?&-s}n|Uju.d@J=cxlF:4ipng>_R44' );
define( 'NONCE_SALT',       ',>Bgdm^]Ub(B`-S(V$q=XCnLut]N*h,Q=vFV{m+FEwd#UlVq=]!WzWwe*5eO{2w(' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
