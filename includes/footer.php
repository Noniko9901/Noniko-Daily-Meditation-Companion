<?php
/**
 * Plugin footer.
 *
 * @package Noniko_Daily_Meditation_Companion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Display plugin footer.
 *
 * @return void
 */
function noniko_dmc_display_footer() {

	$plugin_data = get_file_data(
		plugin_dir_path( dirname( __FILE__ ) ) . 'noniko-daily-meditation-companion.php',
		array(
			'Name'    => 'Plugin Name',
			'Version' => 'Version',
			'License' => 'License',
			'Author'  => 'Author',
		)
	);

	?>
	<footer class="noniko-dmc-footer">

		<div class="noniko-dmc-footer__line"></div>

		<p class="noniko-dmc-footer__text">
			<span class="noniko-dmc-footer__name">
				<?php echo esc_html( $plugin_data['Name'] ); ?>
			</span>

			<span class="noniko-dmc-footer__separator" aria-hidden="true">
				&middot;
			</span>

			<span>
				<?php
				printf(
					/* translators: Plugin version. */
					esc_html__( 'Version %s', 'noniko-daily-meditation-companion' ),
					esc_html( $plugin_data['Version'] )
				);
				?>
			</span>

			<span class="noniko-dmc-footer__separator" aria-hidden="true">
				&middot;
			</span>

			<span>
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
			</span>

			<span class="noniko-dmc-footer__separator" aria-hidden="true">
				&middot;
			</span>

			<span>
				<?php echo esc_html( $plugin_data['License'] ); ?>
			</span>

			<span class="noniko-dmc-footer__separator" aria-hidden="true">
				&middot;
			</span>

			<span>
				<?php echo esc_html( $plugin_data['Author'] ); ?>
			</span>
		</p>

	</footer>
	<?php
}