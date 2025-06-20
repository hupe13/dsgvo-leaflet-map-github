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
		if ( is_user_logged_in() || isset( $_COOKIE['leafext'] ) ) {
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
