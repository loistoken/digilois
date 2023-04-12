<?php
define( 'WP_CACHE', true );

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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'digipotw_wolmart' );

/** Database username */
define( 'DB_USER', 'digipotw_wolmart' );

/** Database password */
define( 'DB_PASSWORD', '_wcYEP(#?,pl' );

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
define( 'AUTH_KEY',         'FBdb@nO+|4+~@CjL&.KTRG{:i;APE<2_L4@3IB2j.-a[E,{P=HkDj,oKGd7>qiBl' );
define( 'SECURE_AUTH_KEY',  '@O,K7zS?|2NALASBY6AjCH2*| xWZ[u1D~+{d@*^Vfz7PCFy8B=+Weac518 l`U<' );
define( 'LOGGED_IN_KEY',    '9 {Lwf>OBPc_6jdz2npJyv?Vah4a~WVvVJQF.St(oI/y3JaY=zZvI8x}X(%4ujO/' );
define( 'NONCE_KEY',        '=k7_C`*Y/}/B2~a-!y=zF69-_YJuQyb`2*Ct6:8=2CL(HW28@QL%?m,aND%8n;Ed' );
define( 'AUTH_SALT',        'K83~d=Fg$v-n:SoP~XV8)3w^Mvme9tyvA.u6|[iQSE^6*RLD]5^KH*E719&Iea29' );
define( 'SECURE_AUTH_SALT', 'JKdkPqk?gbvEO/oh]l/L8jv-x!@o1$+b8LU?,k@WN?0=4yzel[$@:K)O;2y NlxN' );
define( 'LOGGED_IN_SALT',   '+l7zG64;YTj-Jc)eNtuo_8UYpE|.iWj;v;z+$-n!.$<>Il}jPKk<fY@AS7gT{.zZ' );
define( 'NONCE_SALT',       'X?u,5T=Xb_sRcO3{QXV4%h{PVq1$2c{WTV# /-*BZALFvjL>5_QM7Z#3[^Pj;meE' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'jg58k_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
