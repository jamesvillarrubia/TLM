<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'tlm');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


define('FS_METHOD','direct');


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'xb( NqD?s&&8;Pqi<6(q9LpmvE`j|G|.pajq1+4sm^A)C9{lmge^<mA{N!CnR)<2');
define('SECURE_AUTH_KEY',  'G0bPfJJ!}gm4A EumX;}B6ye?k#z_zBO)1H]g*t~+y<p%dT|:uvz5gw*SuR| *f4');
define('LOGGED_IN_KEY',    '^*Ts_+Z]H&u2exO#+`&{:Vpfh<nlr[E,7TH>)4*jr4Y^SJv/.%|K*k47$N2Yjf{O');
define('NONCE_KEY',        'L|+[`j3XEmZ+Nh|z# Nw6J7SQ*RsK9n0C-SO7+gj@}z*(cR}|fXN+%vm !q~jZ!:');
define('AUTH_SALT',        'gOCTH;)5Tn3A~l-HHivW,/-_92&p<1x7~$}=uAHq1ZG-UgB_m)le$F&Kf.9I(hY~');
define('SECURE_AUTH_SALT', 'uyoA?fL({c9;LB uGRrhW@IZ^xojIx>lA+K[Ydej343BOrL=|E(FZ^;$}a0|Wq!U');
define('LOGGED_IN_SALT',   'l68UW:?X|)mEHRl2Bk9R<dJ|0wnC![Z e`Vr//l(wn|5#bLy]ppG,j}%O;p8z!Q3');
define('NONCE_SALT',       'zlAHgLvHHX,h$O.?UzV*_BaCj[50Bg7gK!p|`q+XX+E$j1Dir8+@g7yL3-1VU3Vz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tlm_';

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
