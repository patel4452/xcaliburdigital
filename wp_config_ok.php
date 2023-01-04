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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'xcalibur_demo');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 't1mesStg99');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'kY/]@!8`z$}I*b:<39<tLHe{T}_{r`UAGAE98rY=11Jnrc{!tb#Da)5XM!{mVcg.');
define('SECURE_AUTH_KEY',  ':hueOR5&pe(71JsTfEpn;xg]Nt5=h:U6BL,[:Lj:aD)85`7kC6AUr}3xWx84j`dP');
define('LOGGED_IN_KEY',    ']H.|^lK,$_G5=4H?=Xo2Z|$fN}L50y}rRv.yNAUTl0phAYO)as>T;G!9+!:TPhS8');
define('NONCE_KEY',        'yC<9v&@:/K(fq8,V+W9Dh}[` +[bZFHVnwyoihMprKG4~t?lL9&Hn-P`!^3K93iZ');
define('AUTH_SALT',        'ki@?UgN+E-&,({]qV2/{Ov&yeq|Sm&+nqU39+{DW-Xk?Nx!<=>l1xr4I/-9/(Fl<');
define('SECURE_AUTH_SALT', 'yZG9+ C KIS{kG$CbAt~)t$ACwc1!;r %jCCq@o_?xR:;m7zKm@o:LUJdP&GkFJ2');
define('LOGGED_IN_SALT',   '?~MCzh55OrR1D5}i0iv|psgUK.N4ESxE&i4zR?4OPvlcq:D/ozc.7&s,Zj2M?-cV');
define('NONCE_SALT',       '1[QSi?FYpoE,I8O,@^gU>LD&qc/djL,L.9:U+Vpqxe.:Y{{t_-0jKWPu@^x:>?j4');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
