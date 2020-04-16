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
define('DB_NAME', 'vertech');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '8Cs75MtK0RGOcuWUIDyhw2xxv599P0qCnYnmc31omPk0dY9PpFXeM1Js442Q3MFU');
define('SECURE_AUTH_KEY',  'mCyAT9iamsIfb3t0yyeciZ173uwi3wwv9vS3AR4HG5Ehseq1ZkvmSXHhbqEwHoQJ');
define('LOGGED_IN_KEY',    'rtXJJfUwjNMHjuQg9qaglAwnJf1zYSiMOCl8ZY0o1vmxDEkzSKO8p7dl6DcfWn5o');
define('NONCE_KEY',        'wlmSzmvSg8Q0sWdnIj6kob4EqZuQUe44vJPdo6f6kX5NO6e0La8SVeJpZQJYbmi5');
define('AUTH_SALT',        'HGMeBpDSmp5nU4hnEpFvSolvC0jRccOuqiVQY2V0EulMeOL6t0n4csjxDl95tvHD');
define('SECURE_AUTH_SALT', '0uhddimKXBQYh9rYDae1GtW4jxa5zZAs5eQ99pkiZdjTppa7BLswFX7QtK7hWazR');
define('LOGGED_IN_SALT',   'JD9uqLstKqcXK6x6qy1Z54S2Gt9CLA3km7AtRxvVlomif57BvL0SMTDzjSyEaIYA');
define('NONCE_SALT',       'jL1LEexcygxWd3EbdWMYsDP13o70XbtdEYkPAGGyIypH6K27oMPeUPai9112ogoj');

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
