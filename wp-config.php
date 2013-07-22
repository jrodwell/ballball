<?php

/**

 * The base configurations of the WordPress.

 *

 * This file has the following configurations: MySQL settings, Table Prefix,

 * Secret Keys, WordPress Language, and ABSPATH. You can find more information

 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing

 * wp-config.php} Codex page. You can get the MySQL settings from your web host.

 *

 * This file is used by the wp-config.php creation script during the

 * installation. You don't have to use the web site, you can just copy this file

 * to "wp-config.php" and fill in the values.

 *

 * @package WordPress

 */



// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define('DB_NAME', 'nicetech_ostmodern');



/** MySQL database username */

define('DB_USER', 'nicetech_dbuser');



/** MySQL database password */

define('DB_PASSWORD', '2us4SPeW');



/** MySQL hostname */

define('DB_HOST', 'localhost');



/** Database Charset to use in creating database tables. */

define('DB_CHARSET', 'utf8');



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

define('AUTH_KEY',         '-fkg|#SV(_zD~Lpa-c.xK7hrmJ+:X-}&}xvq^M)=A{D|uU*8c^(~I,iF.tZ~KX[p');
define('SECURE_AUTH_KEY',  's-NX}+fpk%|a.+YzDKa0#>mNEJ +M^q]>|NLqI5H|sS_9Y<}N3Bqsvq76,@BxoC{');
define('LOGGED_IN_KEY',    '-}7{aE`c?p<xt{3xTYp71WW$g{&FsxZ$H1lO2sM)O2@1o(|#N/SeDds^EJL|(i]u');
define('NONCE_KEY',        '-9:en3&2NM,w7oo4LkOf-/H&{>cR*.H>N{yIi.<t*-{5cKHezDSJbokC@|/>~8&r');
define('AUTH_SALT',        'O&Cj> Q<E&J|QGPn9[[tB<U4_-+Ct=y-jr|8TL+wN[|bmNMoN^n-0|v`csgY4=-l');
define('SECURE_AUTH_SALT', ' ]pExe+2zHDH4pK>jn%r|2Ke[|c2rbWX(Z|f[H%>TTyFCxsCs1!7_<m73!fh7 d&');
define('LOGGED_IN_SALT',   'DKZ~N:Ldj8)}V/o5AH<8`2uNf>?8$/Ey&{bT<iJ]%5b-*k9[1[>Jdf-dRG+?Rw +');
define('NONCE_SALT',       'j@+,E0Bm.2Vg/bn;7D-2QAy+jNx*Umz}PbI-`w+VLO(UC#fbOefZb2:0IC^{Pays');



/**#@-*/



/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each a unique

 * prefix. Only numbers, letters, and underscores please!

 */

$table_prefix  = 'wp_';



/**

 * WordPress Localized Language, defaults to English.

 *

 * Change this to localize WordPress. A corresponding MO file for the chosen

 * language must be installed to wp-content/languages. For example, install

 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German

 * language support.

 */

define('WPLANG', '');



/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 */

define('WP_DEBUG', false);



/* Multisite */

define('WP_ALLOW_MULTISITE', true);

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'ostmodern.bashthekeyboard.co.uk');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);



/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */

if ( !defined('ABSPATH') )

	define('ABSPATH', dirname(__FILE__) . '/');



/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');

