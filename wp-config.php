<?php
define('WP_AUTO_UPDATE_CORE', false);// This setting was defined by WordPress Toolkit to prevent WordPress auto-updates. Do not change it to avoid conflicts with the WordPress Toolkit auto-updates feature.
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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_wll4e' );

/** MySQL database username */
define( 'DB_USER', 'wp_j58a7' );

/** MySQL database password */
define('DB_PASSWORD', '9vFo85!UsI');

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '5@DA|/d[1o@0VCNr3%65|X3)+/mNTDMTAX#0&O[KM2F*A0_fgw%g[8Jad#&7|mYQ');
define('SECURE_AUTH_KEY', 'z/9P9fE@48w1aY15/l:T@&7mV7p06MPrJ36&DE/1jBcmh@scq)(77LiKdNhp6aZO');
define('LOGGED_IN_KEY', '0[7yPPEI_JS;+fL+#Tf56T49o[|Mm0zC0[qt6FB#Kws*)W+8u:JD(c/_OT025/;2');
define('NONCE_KEY', 'aI80gB5EBj0(&3ng3*6W([kcXp05EAVci9z#]4ZqA3+[aM@w2Xyr3llS4o1lF%1j');
define('AUTH_SALT', '583gF+|S]uZePc[:sbS~Ju@IO15(K8YuG]:4@/BrYa4#sK7|%v~6iuCoL~1u0Rfg');
define('SECURE_AUTH_SALT', '@!E64x5S:o%3@]%[1:84dc7Ii1)94@U8i_h6Pp@fkQ1J*&0FwX1dhj4_t]q_K_(E');
define('LOGGED_IN_SALT', '~]~7hg2e6NC6eiq]7!N+ZufmE56918!ruP*;ny31h80IYz//|K_)5k@bp;C212!4');
define('NONCE_SALT', 'gHx%i9i5-C2@p]vR88_*Pw_D;_VWN2(4(K6sv[SB4n#b((0!6dKY77:Ryl443&4|');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '9Ynw9o_';


define('WP_ALLOW_MULTISITE', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
