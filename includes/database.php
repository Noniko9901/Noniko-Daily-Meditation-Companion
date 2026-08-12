<?php
/**
 * Database functionality.
 *
 * @package Noniko_Daily_Meditation_Companion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns supported meditation languages.
 *
 * @return array
 */
function noniko_dmc_get_supported_languages() {

	return array(
		'en' => 'English',
		'pl' => 'Polish'
	);
}

/**
 * Returns current meditation language.
 *
 * English is the default/fallback language.
 *
 * @return string
 */
function noniko_dmc_get_current_language() {

	$locale = determine_locale();

	switch ( $locale ) {

		case 'pl_PL':
			return 'pl';

		case 'en_US':
		case 'en_GB':
		default:
			return 'en';
	}
}

/**
 * Returns plugin database table name for language.
 *
 * @param string|null $language Language code.
 * @return string
 */
function noniko_dmc_get_table_name( $language = null ) {

	global $wpdb;

	if ( null === $language ) {
		$language = noniko_dmc_get_current_language();
	}

	$supported_languages = noniko_dmc_get_supported_languages();

	if ( ! isset( $supported_languages[ $language ] ) ) {
		$language = 'en';
	}

	return $wpdb->prefix . 'noniko_dmc_meditations_' . $language;
}

/**
 * Creates all plugin database tables and imports default data.
 *
 * @return void
 */
function noniko_dmc_create_database() {

	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	$languages = noniko_dmc_get_supported_languages();

	foreach ( $languages as $language => $label ) {

		$table_name = noniko_dmc_get_table_name( $language );

		$sql = "CREATE TABLE {$table_name} (
			id bigint(20) unsigned NOT NULL,
			date varchar(5) NOT NULL,
			med_day varchar(100) NOT NULL,
			med_title varchar(255) NOT NULL,
			meditation longtext NOT NULL,
			today_note text NOT NULL,
			PRIMARY KEY (id),
			UNIQUE KEY date (date)
		) {$charset_collate};";

		dbDelta( $sql );

		noniko_dmc_import_sql_file( $language );
	}
}

/**
 * Imports meditation data from bundled SQL file.
 *
 * @param string $language Language code.
 * @return void
 */
function noniko_dmc_import_sql_file( $language ) {

	$supported_languages = noniko_dmc_get_supported_languages();

	if ( ! isset( $supported_languages[ $language ] ) ) {
		return;
	}

	$sql_file = NONIKO_DMC_DIR . 'data/meditations_' . $language . '.sql';

	if ( ! file_exists( $sql_file ) || ! is_readable( $sql_file ) ) {
		return;
	}

	$sql_content = file_get_contents( $sql_file );

	if ( false === $sql_content || '' === trim( $sql_content ) ) {
		return;
	}

	$rows = noniko_dmc_parse_sql_rows( $sql_content );

	if ( empty( $rows ) ) {
		return;
	}

	foreach ( $rows as $row ) {

		if ( 6 !== count( $row ) ) {
			continue;
		}

		noniko_dmc_save_meditation(
			array(
				'id'         => absint( $row[0] ),
				'date'       => sanitize_text_field( $row[1] ),
				'med_day'    => sanitize_text_field( $row[2] ),
				'med_title'  => sanitize_text_field( $row[3] ),
				'meditation' => wp_kses_post( $row[4] ),
				'today_note' => sanitize_text_field( $row[5] ),
			),
			$language
		);
	}

	wp_cache_delete(
		'meditation_count_' . $language,
		'noniko_dmc'
	);
}

/**
 * Parses VALUES rows from SQL file.
 *
 * @param string $sql SQL content.
 * @return array
 */
function noniko_dmc_parse_sql_rows( $sql ) {

	$values_position = stripos( $sql, 'VALUES' );

	if ( false === $values_position ) {
		return array();
	}

	$values = substr(
		$sql,
		$values_position + strlen( 'VALUES' )
	);

	$rows         = array();
	$current      = '';
	$inside_quote = false;
	$escape_next  = false;
	$depth        = 0;
	$length       = strlen( $values );

	for ( $index = 0; $index < $length; $index++ ) {

		$character = $values[ $index ];

		if ( $escape_next ) {
			$current    .= $character;
			$escape_next = false;
			continue;
		}

		if ( '\\' === $character && $inside_quote ) {
			$current    .= $character;
			$escape_next = true;
			continue;
		}

		if ( "'" === $character ) {

			if (
				$inside_quote
				&& isset( $values[ $index + 1 ] )
				&& "'" === $values[ $index + 1 ]
			) {
				$current .= "''";
				$index++;
				continue;
			}

			$inside_quote = ! $inside_quote;
			$current     .= $character;
			continue;
		}

		if ( ! $inside_quote && '(' === $character ) {

			if ( 0 === $depth ) {
				$current = '';
			}

			$depth++;
			continue;
		}

		if ( ! $inside_quote && ')' === $character ) {

			$depth--;

			if ( 0 === $depth ) {

				$row = noniko_dmc_parse_sql_row( $current );

				if ( ! empty( $row ) ) {
					$rows[] = $row;
				}

				$current = '';
			}

			continue;
		}

		if ( $depth > 0 ) {
			$current .= $character;
		}
	}

	return $rows;
}

/**
 * Parses individual SQL row.
 *
 * @param string $row SQL row.
 * @return array
 */
function noniko_dmc_parse_sql_row( $row ) {

	$fields       = array();
	$current      = '';
	$inside_quote = false;
	$escape_next  = false;
	$length       = strlen( $row );

	for ( $index = 0; $index < $length; $index++ ) {

		$character = $row[ $index ];

		if ( $escape_next ) {
			$current    .= $character;
			$escape_next = false;
			continue;
		}

		if ( '\\' === $character && $inside_quote ) {
			$current    .= $character;
			$escape_next = true;
			continue;
		}

		if ( "'" === $character ) {

			if (
				$inside_quote
				&& isset( $row[ $index + 1 ] )
				&& "'" === $row[ $index + 1 ]
			) {
				$current .= "''";
				$index++;
				continue;
			}

			$inside_quote = ! $inside_quote;
			$current     .= $character;
			continue;
		}

		if ( ',' === $character && ! $inside_quote ) {

			$fields[] = noniko_dmc_decode_sql_value(
				trim( $current )
			);

			$current = '';
			continue;
		}

		$current .= $character;
	}

	$fields[] = noniko_dmc_decode_sql_value(
		trim( $current )
	);

	return $fields;
}

/**
 * Decodes one SQL value.
 *
 * @param string $value SQL value.
 * @return string
 */
function noniko_dmc_decode_sql_value( $value ) {

	$value = trim( $value );

	if ( 'NULL' === strtoupper( $value ) ) {
		return '';
	}

	if (
		strlen( $value ) >= 2
		&& "'" === $value[0]
		&& "'" === $value[ strlen( $value ) - 1 ]
	) {
		$value = substr( $value, 1, -1 );
	}

	return str_replace(
		array(
			"''",
			'\\r',
			'\\n',
			'\\t',
			'\\"',
			"\\'",
			'\\\\',
		),
		array(
			"'",
			"\r",
			"\n",
			"\t",
			'"',
			"'",
			'\\',
		),
		$value
	);
}

/**
 * Saves or updates one meditation.
 *
 * @param array  $data     Meditation data.
 * @param string $language Language code.
 * @return bool
 */
function noniko_dmc_save_meditation( $data, $language = 'en' ) {

	global $wpdb;

	$table_name = noniko_dmc_get_table_name( $language );

	if ( empty( $data['id'] ) || empty( $data['date'] ) ) {
		return false;
	}

	$meditation_id = absint( $data['id'] );

	$existing = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT id FROM %i WHERE id = %d LIMIT 1',
			$table_name,
			$meditation_id
		)
	);

	$values = array(
		'id'         => $meditation_id,
		'date'       => sanitize_text_field( $data['date'] ),
		'med_day'    => sanitize_text_field( $data['med_day'] ),
		'med_title'  => sanitize_text_field( $data['med_title'] ),
		'meditation' => wp_kses_post( $data['meditation'] ),
		'today_note' => sanitize_text_field( $data['today_note'] ),
	);

	$formats = array(
		'%d',
		'%s',
		'%s',
		'%s',
		'%s',
		'%s',
	);

	if ( $existing ) {

		$result = $wpdb->update(
			$table_name,
			$values,
			array(
				'id' => $meditation_id,
			),
			$formats,
			array(
				'%d',
			)
		);

		if ( false !== $result ) {

			wp_cache_delete(
				'meditation_' . $language . '_' . sanitize_key( $values['date'] ),
				'noniko_dmc'
			);

			wp_cache_delete(
				'meditation_count_' . $language,
				'noniko_dmc'
			);
		}

		return false !== $result;
	}

	$result = $wpdb->insert(
		$table_name,
		$values,
		$formats
	);

	if ( false !== $result ) {

		wp_cache_delete(
			'meditation_' . $language . '_' . sanitize_key( $values['date'] ),
			'noniko_dmc'
		);

		wp_cache_delete(
			'meditation_count_' . $language,
			'noniko_dmc'
		);
	}

	return false !== $result;
}

/**
 * Returns meditation for specified date.
 *
 * @param string      $date     Date in MM-DD format.
 * @param string|null $language Language code.
 * @return object|null
 */
function noniko_dmc_get_meditation_by_date( $date, $language = null ) {

	global $wpdb;

	$date = sanitize_text_field( $date );

	if ( ! preg_match( '/^\d{2}-\d{2}$/', $date ) ) {
		return null;
	}

	if ( null === $language ) {
		$language = noniko_dmc_get_current_language();
	}

	$language = array_key_exists(
		$language,
		noniko_dmc_get_supported_languages()
	)
		? $language
		: 'en';

	$cache_key = 'meditation_' . $language . '_' . sanitize_key( $date );

	$cached = wp_cache_get(
		$cache_key,
		'noniko_dmc'
	);

	if ( false !== $cached ) {
		return $cached;
	}

	$table_name = noniko_dmc_get_table_name( $language );

	$meditation = $wpdb->get_row(
		$wpdb->prepare(
			'SELECT * FROM %i WHERE date = %s LIMIT 1',
			$table_name,
			$date
		)
	);

	wp_cache_set(
		$cache_key,
		$meditation,
		'noniko_dmc',
		HOUR_IN_SECONDS
	);

	return $meditation;
}

/**
 * Returns number of imported meditations.
 *
 * @param string|null $language Language code.
 * @return int
 */
function noniko_dmc_get_meditation_count( $language = null ) {

	global $wpdb;

	if ( null === $language ) {
		$language = noniko_dmc_get_current_language();
	}

	$language = array_key_exists(
		$language,
		noniko_dmc_get_supported_languages()
	)
		? $language
		: 'en';

	$cache_key = 'meditation_count_' . $language;

	$cached = wp_cache_get(
		$cache_key,
		'noniko_dmc'
	);

	if ( false !== $cached ) {
		return (int) $cached;
	}

	$table_name = noniko_dmc_get_table_name( $language );

	$count = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT COUNT(*) FROM %i',
			$table_name
		)
	);

	$count = (int) $count;

	wp_cache_set(
		$cache_key,
		$count,
		'noniko_dmc',
		HOUR_IN_SECONDS
	);

	return $count;
}


/**
 * Checks whether the plugin database needs to be updated.
 *
 * @return void
 */
function noniko_dmc_maybe_update_database() {

	$current_db_version = NONIKO_DMC_DB_VERSION;

	$installed_db_version = get_option(
		'noniko_dmc_db_version',
		''
	);

	/*
	 * Database is already up to date.
	 */
	if ( $installed_db_version === $current_db_version ) {
		return;
	}

	/*
	 * Recreate and import all bundled database data.
	 */
	noniko_dmc_create_database();

	/*
	 * Store the new database version
	 * only after the import has been completed.
	 */
	update_option(
		'noniko_dmc_db_version',
		$current_db_version
	);
}