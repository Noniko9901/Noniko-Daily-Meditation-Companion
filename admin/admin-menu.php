<?php
/**
 * Administration functionality.
 *
 * @package Noniko_Daily_Meditation_Companion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load administration modules.
 */
require_once NONIKO_DMC_PATH . 'admin/information.php';
require_once NONIKO_DMC_PATH . 'admin/tools.php';

/**
 * Adds plugin administration menu.
 *
 * @return void
 */
function noniko_dmc_add_admin_menu() {

	add_menu_page(
		__(
			'Noniko Meditation',
			'noniko-daily-meditation-companion'
		),
		__(
			'Noniko Meditation ',
			'noniko-daily-meditation-companion'
		),
		'manage_options',
		'noniko-daily-meditation',
		'noniko_dmc_render_information_page',
		'dashicons-format-status',
		25
	);

	add_submenu_page(
		'noniko-daily-meditation',
		__(
			'Information',
			'noniko-daily-meditation-companion'
		),
		__(
			'Information',
			'noniko-daily-meditation-companion'
		),
		'manage_options',
		'noniko-daily-meditation',
		'noniko_dmc_render_information_page'
	);

	add_submenu_page(
		'noniko-daily-meditation',
		__(
			'Tools',
			'noniko-daily-meditation-companion'
		),
		__(
			'Tools',
			'noniko-daily-meditation-companion'
		),
		'manage_options',
		'noniko-daily-meditation-tools',
		'noniko_dmc_render_tools_page'
	);
}

add_action(
	'admin_menu',
	'noniko_dmc_add_admin_menu'
);