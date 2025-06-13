<?php
/**
 *  Shortcode DSGVO snippet for Leaflet Map and its Extensions
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

function leafext_restricted( $atts, $content ) {
	if ( is_singular() || is_archive() || is_home() || is_front_page() ) {
		global $leafext_cookie;
		if ( is_user_logged_in() || isset( $_COOKIE['leafext'] ) || $leafext_cookie ) {
			return $content;
		} else {
			if ( isset( $atts['text'] ) ) {
				$atts['text'] = wp_kses_post( $atts['text'] );
			}
			if ( isset( $atts['okay'] ) ) {
				$atts['okay'] = sanitize_text_field( $atts['okay'] );
			}
			$settings        = leafext_dsgvo_settings();
			$options         = shortcode_atts( $settings, $atts );
			$options['text'] = wp_kses_post( $options['text'] );
			$form            = '<form action="" method="post">';
			$form            = $form . wp_nonce_field( 'leafext_dsgvo', 'leafext_dsgvo_okay' );
			$form            = $form . '<p class="leafext-dsgvo">' . $options['text'] . '</p>';
			$form            = $form .
			'<p class="submit leafext-dsgvo-submit">
			<input type="submit" aria-label="Submit ' . esc_attr( $options['okay'] ) . '" value="' . esc_attr( $options['okay'] ) . '" name="leafext_button" /></p>
			</form>';
			return $form;
		}
	}
}
add_shortcode( 'leafext-cookie', 'leafext_restricted' );

function leafext_dsgvo_short_code_help() {
	$text = '<h3>' . sprintf(
		/* translators: %s is leafext_cookie */
		__( 'Shortcode %s', 'dsgvo-leaflet-map' ),
		'leafext-cookie'
	) . '</h3>';
	if ( is_singular() || is_archive() ) {
		$codestyle = '';
	} else {
		leafext_enqueue_admin();
		$codestyle = ' class="language-coffeescript"';
	}

	$text .= '<p>' . sprintf(
	/* translators: %s is the shortcode */
		__(
			'You can use the shortcode %1$s anywhere in your pages / posts.',
			'dsgvo-leaflet-map'
		),
		'<code>leafext-cookie</code>'
	) . '</p>';
	$text .= '<p>' . sprintf(
	/* translators: %s are the shortcode */
		__(
			'All content between %1$s and %2$s will only be displayed if the user agrees. The cookie is the same %3$s.',
			'dsgvo-leaflet-map'
		),
		'<code>&#091;leafext-cookie]</code>',
		'<code>[/leafext-cookie]</code>',
		'(<code>leafext</code>)'
	) . '</p>';
	$text .= '<h3>Code</h3>';
	$text .= '<p><pre' . $codestyle . '><code' . $codestyle . '>&#091;leafext-cookie text="..." okay="..."]</code></pre></p>';
	$text .= '<p>&nbsp;&nbsp;&nbsp;<i>' . __( 'any content, but not a shortcode', 'dsgvo-leaflet-map' ) . '</i></p>';
	$text .= '<p><pre' . $codestyle . '><code' . $codestyle . '>&#091;/leafext-cookie]</code></pre></p>';

	$text .= '<p>' . sprintf(
		/* translators: %s are options */
		__( 'You can’t write another shortcode in %s shortcode, because WordPress doesn’t allow to use nested shortcodes.', 'dsgvo-leaflet-map' ),
		'<code>&#091;leafext-cookie]</code>'
	) . '</p>';

	$text .= '<h3>' . __( 'Options', 'dsgvo-leaflet-map' ) . '</h3>';

	$text .= '<p>' . sprintf(
		/* translators: %s are options */
		__( 'The options %1$s and %2$s are optional. Defaults are the %3$ssettings%4$s of', 'dsgvo-leaflet-map' ),
		'<code>text</code>',
		'<code>okay</code>',
		'<a href="' . esc_url( '?page=' . LEAFEXT_DSGVO_PLUGIN_NAME . '&tab=help' ) . '">',
		'</a>'
	);
	$text .= ' <b>' . __( 'Text', 'dsgvo-leaflet-map' ) . '</b> ' . __( 'and', 'dsgvo-leaflet-map' ) . ' <b>' . __( 'Submit Button', 'dsgvo-leaflet-map' ) . '</b>.';
	$text .= '</p>';

	$text = $text . '<h3><a href="https://leafext.de/extra/dsgvo-example/">' . __( 'Example', 'dsgvo-leaflet-map' ) . '</a></h3>';

	if ( is_singular() || is_archive() ) {
		return $text;
	} else {
		echo wp_kses_post( $text );
	}
}
