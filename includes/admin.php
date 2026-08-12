<?php
/**
 * Administration functionality.
 *
 * @package Noniko_Daily_Meditation_Companion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Adds plugin settings page.
 *
 * @return void
 */
function noniko_dmc_add_admin_menu() {
	add_menu_page(
	__(
		'Noniko Daily Meditation',
		'noniko-daily-meditation-companion'
	),
	__(
		'Daily Meditation',
		'noniko-daily-meditation-companion'
	),
	'manage_options',
	'noniko-daily-meditation',
	'noniko_dmc_render_admin_page',
	'dashicons-format-status',
	25
);


}

add_action(
	'admin_menu',
	'noniko_dmc_add_admin_menu'
);

/**
 * Renders plugin administration page.
 *
 * @return void
 */
function noniko_dmc_render_admin_page() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$meditation_count = noniko_dmc_get_meditation_count();
	?>

	<div class="wrap">

		<h1>
			<?php
			echo esc_html__(
				'Noniko Daily Meditation Companion',
				'noniko-daily-meditation-companion'
			);
			?>
		</h1>

		<div class="card">

			<h2>
				<?php
				echo esc_html__(
					'Database information',
					'noniko-daily-meditation-companion'
				);
				?>
			</h2>

			<table class="widefat striped">

				<tbody>

					<tr>

						<td>
							<strong>
								<?php
								echo esc_html__(
									'Plugin version',
									'noniko-daily-meditation-companion'
								);
								?>
							</strong>
						</td>

						<td>
							<?php
							echo esc_html(
								NONIKO_DMC_VERSION
							);
							?>
						</td>

					</tr>

					<tr>

			</table>

		</div>

		<div class="card">

			<h2>
				<?php
				echo esc_html__(
					'Data import',
					'noniko-daily-meditation-companion'
				);
				?>
			</h2>

			<p>
				<?php
				echo esc_html__(
					'The data source consists of language-specific SQL files located in the plugin\'s data directory',
					'noniko-daily-meditation-companion'
				);
				?>
			</p>

			<form
				method="post"
				action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
			>

				<input
					type="hidden"
					name="action"
					value="noniko_dmc_import"
				/>

				<?php
				wp_nonce_field(
					'noniko_dmc_import',
					'noniko_dmc_import_nonce'
				);
				?>

				<?php
				submit_button(
					__(
						'Re-import database',
						'noniko-daily-meditation-companion'
					),
					'primary',
					'submit',
					false
				);
				?>

			</form>

		</div>

		<div class="card">

			<h2>
				<?php
				echo esc_html__(
					'Shortcode',
					'noniko-daily-meditation-companion'
				);
				?>
			</h2>

			<p>
				<?php
				echo esc_html__(
					'To display today s meditation, use:',
					'noniko-daily-meditation-companion'
				);
				?>
			</p>

			<p>
				<code>	<?php
			echo esc_html__(
				'[noniko_daily_meditation]',
				'noniko-daily-meditation-companion'
			);
			?></code>
			</p>

			<p>
				<?php
				echo esc_html__(
					'To display a specific day:',
					'noniko-daily-meditation-companion'
				);
				?>
			</p>

			<p>
				<code>
					<?php
			echo esc_html__(
				'[noniko_daily_meditation date="01-03"]',
				'noniko-daily-meditation-companion'
			);
			?>
			</code>
			</p>

		</div>

	</div>

	<?php
}

/**
 * Handles manual database import.
 *
 * @return void
 */
function noniko_dmc_handle_import() {

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die(
			esc_html__(
				'You do not have sufficient permissions.',
				'noniko-daily-meditation-companion'
			)
		);
	}

	check_admin_referer(
		'noniko_dmc_import',
		'noniko_dmc_import_nonce'
	);

	noniko_dmc_create_database();

	$redirect_url = add_query_arg(
		array(
			'page'   => 'noniko-daily-meditation',
			'import' => 'success',
		),
		admin_url( 'options-general.php' )
	);

	wp_safe_redirect( $redirect_url );
	exit;
}

add_action(
	'admin_post_noniko_dmc_import',
	'noniko_dmc_handle_import'
);

/**
 * Displays import result notice.
 *
 * @param string $hook_suffix Current admin page suffix.
 * @return void
 */
function noniko_dmc_admin_notices( $hook_suffix ) {

	if ( 'settings_page_noniko-daily-meditation' !== $hook_suffix ) {
		return;
	}

	$import_status = filter_input(
		INPUT_GET,
		'import',
		FILTER_SANITIZE_FULL_SPECIAL_CHARS
	);

	if ( 'success' !== $import_status ) {
		return;
	}
	?>

	<div class="notice notice-success is-dismissible">

		<p>
			<?php
			echo esc_html__(
				'The database was imported successfully.',
				'noniko-daily-meditation-companion'
			);
			?>
		</p>

	</div>

	<?php
}

add_action(
	'admin_notices',
	'noniko_dmc_admin_notices'
);

