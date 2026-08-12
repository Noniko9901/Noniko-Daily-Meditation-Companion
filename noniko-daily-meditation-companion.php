<?php
/**
 * Plugin Name: Noniko Daily Meditation Companion
 * Plugin URI: https://github.com/noniko9901/noniko-daily-meditation-companion
 * Description: Displays a daily meditation from a local WordPress database.
 * Version: 1.0.0.0
 * Requires at least: 6.9
 * Requires PHP: 7.4
 * Author: Noniko9901
 * Author URI: https://github.com/noniko9901
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: noniko-daily-meditation-companion
 * Domain Path: /languages
 *
 * @package Noniko_Daily_Meditation_Companion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin version.
 *
 * @var string
 */
define( 'NONIKO_DMC_VERSION', '1.0.0' );

/**
 * Plugin main file.
 *
 * @var string
 */
define( 'NONIKO_DMC_FILE', __FILE__ );

/**
 * Plugin directory.
 *
 * @var string
 */
define( 'NONIKO_DMC_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Plugin URL.
 *
 * @var string
 */
define( 'NONIKO_DMC_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load database functionality.
 */
require_once NONIKO_DMC_DIR . 'includes/database.php';

/**
 * Load shortcode functionality.
 */
require_once NONIKO_DMC_DIR . 'includes/shortcode-pl.php';
require_once NONIKO_DMC_DIR . 'includes/shortcode-en.php';

/**
 * Load admin functionality.
 */
if ( is_admin() ) {
	require_once NONIKO_DMC_DIR . 'includes/admin.php';
}

/**
 * Activate plugin.
 *
 * @return void
 */
function noniko_dmc_activate() {

	noniko_dmc_create_database();
}

register_activation_hook(
	NONIKO_DMC_FILE,
	'noniko_dmc_activate'
);

/**
 * Enqueues frontend styles.
 *
 * @return void
 */
function noniko_dmc_enqueue_styles() {

	wp_enqueue_style(
		'noniko-dmc-meditation',
		NONIKO_DMC_URL . 'assets/css/meditation.css',
		array(),
		NONIKO_DMC_VERSION
	);
}

add_action(
	'wp_enqueue_scripts',
	'noniko_dmc_enqueue_styles'
);

