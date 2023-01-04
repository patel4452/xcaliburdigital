<?php

define('WP_HOME','https://xcaliburdigital.com/revamp/');
define('WP_SITEURL','https://xcaliburdigital.com/revamp/');

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
define('DB_NAME', 'xcaliburdigital_new');

/** MySQL database username */
define('DB_USER', 'xcalibur_new');

/** MySQL database password */
define('DB_PASSWORD', 'xcaliburdb22#');

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
 
//define('WP_HOME','http://xcaliburdigital.com');
//define('WP_SITEURL','http://xcaliburdigital.com');

define('AUTH_KEY',         '6:s(wb-vUKJ[h$vXW60;3LfkZRXzU=E!+um%X)]M4JFmti&x|{md[>x1~uP~w@5Y');
define('SECURE_AUTH_KEY',  '?4S5q3JwpJ&Q1S,Tf`N,N&p-QwmC#uSM3|ayZ_BlH27.$O^=b)ao?B3`,dF0IU_#');
define('LOGGED_IN_KEY',    'm=OPs/=9*fON4uR7!a]I#LFbID.UHud3)^loPzB;(@m0??f;{IIdlr^0(-g|V&9]');
define('NONCE_KEY',        'KvU2YMz4=t$CSUPUc}YhuAi0OD*jJ_di]`/4bb6M~IkDnQP3/xBVA/t&,yo)X2XK');
define('AUTH_SALT',        '[-f| rLDckp@NeUL<Eqcg=U*G7si`AqvT [hTnA{%C/ZJ^ %|Da<+JfCW@*@%)-.');
define('SECURE_AUTH_SALT', 'lIx77,SJEBP)9d<T+ilb`P^s*mgYb4?1C?+Lcz88hGsjerB_?5oaSkaLAMo5^V2,');
define('LOGGED_IN_SALT',   '%c-Bg=K%Dz$_|r3)%58fj_5`/Ox5GfAkg$B+An@X)c~ab*rCvn<=#KTo/yy-UF,$');
define('NONCE_SALT',       'L7*`e<8:|Ukio>eCQhJ!aa1_Xn)e!+!#jl.o`> f_rX)Bza}XJ<)rSi<u>n{Br61');

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
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
define('FS_METHOD','direct');


