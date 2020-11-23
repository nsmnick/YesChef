<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

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


define('DB_NAME', 'yeschefv2');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

// TEST
define('GA_CODE', 'UA-177763557-1');
define('GA_ADSCODE', 'AW-473315826');

define('LOG_EVENTS', true);


// STG
// define('DB_NAME', 'nsmdigit_yeschef');
// define('DB_USER', 'nsmdigit_yeschef');
// define('DB_PASSWORD', 'V%7kGQsITl7V');

// LIVE
// define('DB_NAME', 'dbpgc5sce68gm7');
// define('DB_USER', 'uqqc5gt7fr433');
// define('DB_PASSWORD', '1;wNi#34-1m6');

// LIVE
//define('GA_CODE', 'UA-177763557-1');
//define('LOG_EVENTS', true);



define('DB_HOST', 'localhost');
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
define('AUTH_KEY',         'HpU;}aW.RDm<u?lT$GC x~!TgJ2-(RkRqxxIc9Aavd*:@wOT//4NL[yNm  k8%9G');
define('SECURE_AUTH_KEY',  'OE7s_lv7z.)uQCEd9ILV2zZmjLg|IKQIg{gSy4l6|<b%k<%W:wP$~N6rxmU [8vZ');
define('LOGGED_IN_KEY',    ';EA9A<h>VkiK:i3J=AV!$f/_*=<$|HM@dB4p8N61o0DE+1wqDJ~Oc)~4{`G}F:wU');
define('NONCE_KEY',        'e;1?+5w,NP,+[]jy&/RLi,]R=!Zj_(QT23*`V6H;2J^Y= @.bcdawHgowq^&.>e8');
define('AUTH_SALT',        'ghXtv[eGlT?ci(cgOIH9.7WQ&(Z.L8^ere8s$gJ8OTx@SwVWL%J<~Yi4(l79=BM.');
define('SECURE_AUTH_SALT', 'lo<-Qx%hsmJ/cz6c_k#f=L6^Sv3c1G#@Wxf~et.E`}e?}_,F}nI|!1y6yHIJ[OIh');
define('LOGGED_IN_SALT',   '$?R`(#@jlFSg#r~SAA,LFwwWE6kn=X[x0[j4YoHj^]pA;%rx/qXe>boNbIh9{haR');
define('NONCE_SALT',       '?iVpOcP:,!n,pTTS{ 2URP~@pg*V!1o2x7AEN6!h{K[4Y6,s?;?>cW)-IcYU%.<N');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'yc_';

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
