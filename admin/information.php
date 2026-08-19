<?php
/**
 * Information administration page.
 *
 * @package Noniko_Daily_Meditation_Companion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders information page.
 *
 * @return void
 */
function noniko_dmc_render_information_page() {

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

        		<!-- Shortcodes -->

		<div class="card">

			<h2>
				<?php
				echo esc_html__(
					'Shortcodes',
					'noniko-daily-meditation-companion'
				);
				?>
			</h2>
			
			</h3>

			<p>
				<?php
				echo esc_html__(
					'To display today\'s meditation, use:',
					'noniko-daily-meditation-companion'
				);
				?>
			</p>

			<p>
				<code>[noniko_daily_meditation]</code>
			</p>


			<p>
				<?php
				echo esc_html__(
					'To display a meditation for a specific day, use:',
					'noniko-daily-meditation-companion'
				);
				?>
			</p>

			<p>
				<code>[noniko_daily_meditation date="01-03"]</code>
			</p>

		</div>

	</div>
		
		<!-- Translation information -->

		<div class="card">

			<h2>
				<?php
				echo esc_html__(
					'Languages and translations',
					'noniko-daily-meditation-companion'
				);
				?>
			</h2>


			<p>
				<?php
				echo esc_html__(
					'The plugin contains 366 meditation records. The meditation content is stored in the plugin database and translated independently from the WordPress translation system.',
					'noniko-daily-meditation-companion'
				);
				?>
			</p>

			<table class="widefat striped">

				<tbody>

					<tr>

						<td>
							<strong>
								<?php
								echo esc_html__(
									'Translation source',
									'noniko-daily-meditation-companion'
								);
								?>
							</strong>
						</td>

						<td>
							<?php
							echo esc_html__(
								'Plugin database',
								'noniko-daily-meditation-companion'
							);
							?>
						</td>

					</tr>

					<tr>

						<td>
							<strong>
								<?php
								echo esc_html__(
									'Number of records',
									'noniko-daily-meditation-companion'
								);
								?>
							</strong>
						</td>

						<td>
							<?php
							echo esc_html( '366' );
							?>
						</td>

					</tr>

					<tr>

						<td>
							<strong>
								<?php
								echo esc_html__(
									'What is translated?',
									'noniko-daily-meditation-companion'
								);
								?>
							</strong>
						</td>

						<td>
							<?php
							echo esc_html__(
								'Meditation content stored in the plugin database.',
								'noniko-daily-meditation-companion'
							);
							?>
						</td>

					</tr>

				</tbody>

			</table>

			<hr />

			<h3>
				<?php
				echo esc_html__(
					'WordPress plugin translations',
					'noniko-daily-meditation-companion'
				);
				?>
			</h3>

			<p>
				<?php
				echo esc_html__(
					'The plugin interface is translated using the official WordPress translation system.',
					'noniko-daily-meditation-companion'
				);
				?>
			</p>

			<p>
				<?php
				echo esc_html__(
					'This includes menus, buttons, notices, descriptions, settings and other user interface text.',
					'noniko-daily-meditation-companion'
				);
				?>
			</p>

			<p>
				<?php
				echo esc_html__(
					'These translations are managed through WordPress.org and GlotPress and are separate from the meditation data translations.',
					'noniko-daily-meditation-companion'
				);
				?>
			</p>

			<p>
				<a
					class="button"
					href="https://translate.wordpress.org/projects/wp-plugins/noniko-daily-meditation-companion/"
					target="_blank"
					rel="noopener noreferrer"
				>
					<?php
					echo esc_html__(
						'View available translations',
						'noniko-daily-meditation-companion'
					);
					?>
				</a>
			</p>

		</div>



    <!-- Plugin information -->

		<div class="card">

			<h2>
				<?php
				echo esc_html__(
					'Information',
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
									'Plugin version:',
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

						<td>
							<strong>
								<?php
								echo esc_html__(
									'Database version:',
									'noniko-daily-meditation-companion'
								);
								?>
							</strong>
						</td>

						<td>
							<?php
							echo esc_html(
								NONIKO_DMC_DB_VERSION
							);
							?>
						</td>

					</tr>

				</tbody>

			</table>

		</div>


	<?php
}