<?php
error_reporting(0);
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

//define('DB_NAME', 'tpocom_dash');

define('DB_NAME', 'campus');


/** MySQL database username */
//define('DB_USER', 'tpocom_dash');

define('DB_USER', 'campusadmin');

/** MySQL database password */
//define('DB_PASSWORD', 'w2P!9A-Si0');

define('DB_PASSWORD', 'Mankind0');

/** MySQL hostname */
//define('DB_HOST', 'localhost');

define('DB_HOST', 'campus.c8hmq6y4ejrq.ap-southeast-2.rds.amazonaws.com');

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
define('AUTH_KEY',         'dtiqmtcyez34dcokdgdexter8xoix509u2dsprki1tczyd2d2tocsxy2pnggmij9');
define('SECURE_AUTH_KEY',  'zzriiaouffxsi0wodafnrdaqaewxggrvzlhp7vqmbckslkifou0oogrsdaxs47z9');
define('LOGGED_IN_KEY',    'bziejhvr3pfkvgvszxkb0f1jp0wnrgij8mtbc1bqfgrvsgijykyekok57v27xcnm');
define('NONCE_KEY',        '3c9r4vxevmr8hlmg5t5chmtahux2dpiohbnd5xpolcjhpaq1eaawti1bm9wsmxsw');
define('AUTH_SALT',        '3o9ti30d6bhawuraf196id3mmidbzkcnzitkuo1jvymchzatrgm1ilgqhwia8s1s');
define('SECURE_AUTH_SALT', 'yc8gjcxliqsg5uembhbx6tk2kijwdowxppqqlg1wxrzr6s7jjfkyk3pja9cmbtqt');
define('LOGGED_IN_SALT',   'njvdzmsmnvdy6wkozpw4t5uv28ls6usealdyzqlvmg3uilqrkleqw6apfk7g4vgv');
define('NONCE_SALT',       'sm5opfa4ngfg2aniozxmyvdiuidxnkbir8lfofm2xcrcjmzalqaemwzqfdnxjboi');

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
define('WP_DEBUG', FALSE);
define('BACKUPBUDDY_API_ENABLE', true );


//define( 'AUTOMATIC_UPDATER_DISABLED', true );
//define( 'DISALLOW_FILE_EDIT', true );
//define( 'DISALLOW_FILE_MODS', true );
//define( 'REVISR_GIT_DIR', dirname( __FILE__ ).'/Git' );
define('FTP_USER', 'timfoster'); // Your FTP username
define('FTP_PASS', 'xpwkdjfusyakdjghtNNNsss'); // Your FTP password
define('FTP_HOST', 'localhost'); // Your FTP URL:Your FTP port

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
 