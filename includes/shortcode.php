<?php
/**
 * Shortcode functionality.
 *
 * @package Noniko_Daily_Meditation_Companion
 */

defined( 'ABSPATH' ) || exit;


/**
 * Registers the meditation shortcode.
 *
 * Shortcode:
 * [noniko_daily_meditation]
 *
 * Optional date:
 * [noniko_daily_meditation date="01-03"]
 *
 * @return void
 */
function noniko_dmc_register_shortcodes() {

	add_shortcode(
		'noniko_daily_meditation',
		'noniko_dmc_render_meditation_shortcode'
	);
}

add_action(
	'init',
	'noniko_dmc_register_shortcodes'
);


/**
 * Renders the meditation shortcode.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function noniko_dmc_render_meditation_shortcode( $atts ) {

	$atts = shortcode_atts(
		array(
			'date' => '',
		),
		$atts,
		'noniko_daily_meditation'
	);


	$date = sanitize_text_field(
		$atts['date']
	);


	/*
	 * If no date was supplied,
	 * use today's date.
	 *
	 * Database format: MM-DD.
	 */
	if ( '' === $date ) {

		$date = wp_date(
			'm-d',
			current_time( 'timestamp' )
		);
	}


	/*
	 * Get meditation using the current
	 * WordPress language.
	 *
	 * noniko_dmc_get_meditation_by_date()
	 * automatically uses:
	 *
	 * pl_PL → pl
	 * en_US → en
	 */
	$meditation = noniko_dmc_get_meditation_by_date(
		$date
	);


	if ( ! $meditation ) {

		return '<p class="noniko-dmc-meditation__error">' .
			esc_html__(
				'No meditation was found for this day.',
				'noniko-daily-meditation-companion'
			) .
			'</p>';
	}


	/*
	 * Start output buffering.
	 */
	ob_start();
	?>

	<article class="noniko-dmc-meditation">

		<header class="noniko-dmc-meditation__header">

			<p class="noniko-dmc-meditation__day">
				<?php
				echo esc_html(
					$meditation->med_day
				);
				?>
			</p>

			<h2 class="noniko-dmc-meditation__title">
				<?php
				echo esc_html(
					$meditation->med_title
				);
				?>
			</h2>

		</header>


		<div class="noniko-dmc-meditation__content">

			<?php
			echo wp_kses_post(
				wpautop(
					$meditation->meditation
				)
			);
			?>

		</div>


		<?php if ( '' !== trim( $meditation->today_note ) ) : ?>

			<footer class="noniko-dmc-meditation__note">

				<h3 class="noniko-dmc-meditation__note-title">

					<?php
					echo esc_html__(
						'Just for Today: ',
						'noniko-daily-meditation-companion'
					);
					?>

				</h3>


				<p class="noniko-dmc-meditation__note-text">

					<?php
					echo esc_html(
						$meditation->today_note
					);
					?>

				</p>

			</footer>

		<?php endif; ?>

	</article>

	<?php
    noniko_dmc_display_footer();
	return ob_get_clean();
}