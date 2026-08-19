<?php
/**
 * Administration tools.
 *
 * @package Noniko_Daily_Meditation_Companion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders tools page.
 *
 * @return void
 */
function noniko_dmc_render_tools_page() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>

	<div class="wrap">

		<h1>
			<?php
			echo esc_html__(
				'Tools',
				'noniko-daily-meditation-companion'
			);
			?>
		</h1>

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
					'The data source consists of language-specific SQL files located in the plugin\'s data directory.',
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
			'page'   => 'noniko-daily-meditation-tools',
			'import' => 'success',
		),
		admin_url( 'admin.php' )
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

	if ( 'daily-meditation_page_noniko-daily-meditation-tools' !== $hook_suffix ) {
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