<?php
/**
 * Functions DSGVO for sgpx
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

function leafext_render_sgpx( $output, $block ) {
	if ( isset( $block['blockName'] ) && 'wp-gpx-maps/map' === $block['blockName'] ) {
		if ( is_singular() || is_archive() || is_home() || is_front_page() ) {
			$output = leafext_sgpx_form( $output );
		}
	}
	return $output;
}
add_filter( 'render_block', 'leafext_render_sgpx', 10, 2 );

function leafext_sgpx_form( $output ) {
	global $leafext_cookie_mapid;
	if ( isset( $_COOKIE['leafext'] ) ) {
		if ( isset( $_SERVER['REQUEST_METHOD'] ) && sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) === 'POST' ) {
			wp_enqueue_style(
				'leafext-dsgvo-css',
				plugins_url( '/../css/leafext-dsgvo.css', __FILE__ ),
				array(),
				LEAFEXT_DSGVO_PLUGIN_VERSION
			);
			$output = str_replace( 'class="leaflet-map', 'id="map_' . $leafext_cookie_mapid . '" class="leaflet-map', $output );
		}
		return $output;
	}
	wp_enqueue_style(
		'leafext-dsgvo-css',
		plugins_url( '/../css/leafext-dsgvo.css', __FILE__ ),
		array(),
		LEAFEXT_DSGVO_PLUGIN_VERSION
	);
	$formbegin_safe = '<form action="#map_' . $leafext_cookie_mapid . '" method="post">';
	$formbegin_safe = $formbegin_safe . wp_nonce_field( 'leafext_dsgvo', 'leafext_dsgvo_okay', true, false );
	$settings       = leafext_dsgvo_settings();
	$formtext       = '<p>' . $settings['text'] . '</p>';
	$formend_safe   = '<p class="submit leafext-dsgvo-submit">
		<input type="submit" aria-label="Submit ' . esc_attr( $settings['okay'] ) . '" value="' . esc_attr( $settings['okay'] ) . '" name="leafext_button" /></p>
		</form>';

	global $leafext_okay;
	global $leafext_sgpx;

	if ( ! isset( $leafext_okay ) ) {
		$leafext_okay = true;
		$form         = true;
	} else {
		$count = filter_var( $settings['count'], FILTER_VALIDATE_BOOLEAN );
		if ( $count ) {
			$form = true;
		} else {
			$form = false;
		}
	}

	// search width and height
	$search = 'style="width:';
	$pos    = strpos( $output, $search );
	if ( $pos === false ) {
		$search = 'style="height:';
		$pos    = strpos( $output, $search );
	}
	$style  = substr( $output, $pos - strlen( $output ) );
	$search = 'position:relative';
	$pos    = strpos( $style, $search );
	if ( $pos === false ) {
		$search = '"></div>';
		$pos    = strpos( $style, $search );
	}
	$style  = substr( $style, 0, $pos );
	$output = '<div class="leafext-dsgvo" ' . $style .
		' background: linear-gradient(' . esc_attr( $settings['color'] ) . ',' . esc_attr( $settings['color'] ) . '), url(' . esc_url( $settings['mapurl'] ) . ');" ><div style="width: 70%; max-height: 100%;">'
		. ( $form ? $formbegin_safe . wp_kses_post( $formtext ) . $formend_safe : '' ) . '</div></div>';
	return $output;
}
