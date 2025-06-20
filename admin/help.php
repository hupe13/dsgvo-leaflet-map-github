<?php
/**
 * Help DSGVO for leaflet-map
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

function leafext_dsgvo_main_help() {
	leafext_dsgvo_help_what();
	echo '<h3>';
	esc_html_e( 'Settings', 'dsgvo-leaflet-map' );
	echo '</h3>';
	echo '<p>';
	esc_html_e( 'Test it in a private browser window.', 'dsgvo-leaflet-map' );
	echo '</p>';
	leafext_dsgvo_ttfp_help();
	echo '<form method="post" action="options.php">';
	settings_fields( 'leafext_settings_dsgvo' );
	wp_nonce_field( 'leafext_dsgvo', 'leafext_dsgvo_nonce' );
	do_settings_sections( 'leafext_settings_dsgvo' );
	if ( current_user_can( 'manage_options' ) ) {
		submit_button();
		submit_button( __( 'Reset', 'dsgvo-leaflet-map' ), 'delete', 'delete', false );
	}
	echo '</form>';
}

function leafext_dsgvo_help() {
	$text = '<h2>' .
	__( 'GDPR (DSGVO) snippet for Leaflet Map and its Extensions', 'dsgvo-leaflet-map' )
	. '</h2>';
	echo wp_kses_post( $text );
}

function leafext_dsgvo_help_what() {
	$text  = '<h3>' . __( 'Function', 'dsgvo-leaflet-map' ) . '</h3>';
	$text .= '<p>' . sprintf(
	/* translators: %1$s is leaflet-map, %2$s is the cookie name */
		__( 'The plugin prevents the shortcode %1$s from being executed. If the user agrees, the cookie %2$s is set and %1$s is executed.', 'dsgvo-leaflet-map' ),
		'<code>&#091;leaflet-map]</code>',
		'<code>leafext</code>'
	) . '</p>';
	$text .= '<p>' .
	sprintf(
		/* translators: %s are hrefs. */
		__(
			'An example is %1$shere%2$s',
			'dsgvo-leaflet-map'
		),
		'<a href="https://leafext.de/extra/dsgvo-example/">',
		'</a>'
	);
	$text .= '.</p>';
	echo wp_kses_post( $text );
}

function leafext_dsgvo_ttfp_help() {
	if ( leafext_plugin_active( 'polylang' ) ) {
		echo '<h3>Polylang</h3>';
		$ttfp = '<a href="' . esc_url( 'https://wordpress.org/plugins/theme-translation-for-polylang/' ) . '">Theme and plugin translation for Polylang (TTfP)</a> ';
		if ( leafext_plugin_active( 'polylang-theme-translation' ) ) {
			echo '<ul><li>';
			echo wp_kses_post( $ttfp ) . ' ';
			$ttfp = true;
			esc_html_e( 'is active.', 'dsgvo-leaflet-map' );
			echo '</li><li>';
			esc_html_e( 'Go to', 'dsgvo-leaflet-map' );
			echo ' <a href="' . esc_url( admin_url( 'admin.php' ) . '?page=mlang_import_export_strings' ) . '">';
			esc_html_e( 'Settings', 'dsgvo-leaflet-map' );
			echo '</a>, ';
			esc_html_e( 'enable', 'dsgvo-leaflet-map' );
			echo ' <code>' . esc_html( LEAFEXT_DSGVO_PLUGIN_NAME ) . '</code> ';
			esc_html_e( 'and', 'dsgvo-leaflet-map' );
			echo ' <a href="' . esc_url( admin_url( 'admin.php' ) . '?page=mlang_strings&s&group=TTfP%3A+' . LEAFEXT_DSGVO_PLUGIN_NAME ) . '">';
			esc_html_e( 'fill in your text', 'dsgvo-leaflet-map' );
			echo '</a>!';
			echo '</li></ul>';
		} else {
			printf(
			/* translators: %s is a link. */
				esc_html__( 'If you wish to translate these strings in %s use', 'dsgvo-leaflet-map' ),
				' <a href="' . esc_url( 'https://wordpress.org/plugins/polylang/' ) . '">Polylang</a> '
			);
			echo ' ' . wp_kses_post( $ttfp ) . '.';
			$ttfp = false;
		}
	}
}
