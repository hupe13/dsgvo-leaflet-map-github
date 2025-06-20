<?php
/**
 *  Shortcode DSGVO snippet for Leaflet Map and its Extensions
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

function leafext_get_cookie_time( $atts, $content ) {
	if ( is_singular() || is_archive() || is_home() || is_front_page() ) {
		if ( isset( $_COOKIE['leafext'] ) ) {
			$cookie_time = sanitize_key( $_COOKIE['leafext'] );

			if ( isset( $atts['format'] ) ) {
				$format = $atts['format'];
			} else {
				$format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
			}

			$gmt = isset( $atts['gmt'] ) ? $atts['gmt'] : 0;
			if ( $gmt ) {
				$content = gmdate( $format, $cookie_time );
			} else {
				$content = wp_date( $format, $cookie_time );
			}

			$before = isset( $atts['before'] ) ? $atts['before'] : '';
			$after  = isset( $atts['after'] ) ? $atts['after'] : '';

			$content = $before . $content . $after;

		} else {
			$content = isset( $atts['noset'] ) ? $atts['noset'] : '';
		}
	}
	return $content;
}
add_shortcode( 'leafext-cookie-time', 'leafext_get_cookie_time' );

function leafext_form_delete_cookie( $atts, $content ) {
	if ( is_singular() || is_archive() || is_home() || is_front_page() ) {
		if ( isset( $_COOKIE['leafext'] ) ) {
			if ( isset( $atts['delete'] ) ) {
				$submit = $atts['delete'];
			} else {
				$submit = __( 'Delete', 'dsgvo-leaflet-map' );
			}
			$content  = '<form method="post">' . "\n";
			$content .= '<input type="hidden" name="cookie" value="delete">' . "\n";
			$content .= '<input type="hidden" name="origin" value=' . get_permalink( get_the_ID() ) . '>' . "\n";
			$content .= wp_nonce_field( 'leafext_dsgvo', 'leafext_dsgvo_cookie' ) . "\n";
			$content .= '<div class="submit leafext-dsgvo-submit leafext-dsgvo-delete-submit"><input type="submit" aria-label="Submit ' . esc_attr( $submit ) . '" value="' . esc_attr( $submit ) . '" name="leafext_cookie_button" /></div>' . "\n";
			$content .= '</form>' . "\n";
		}
	}
	return $content;
}
add_shortcode( 'leafext-delete-cookie', 'leafext_form_delete_cookie' );

function leafext_delete_cookie() {
	if ( isset( $_SERVER['REQUEST_METHOD'] ) && sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) === 'POST' && ! empty( $_POST['leafext_cookie_button'] ) ) {
		if ( isset( $_REQUEST['leafext_dsgvo_cookie'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['leafext_dsgvo_cookie'] ) ), 'leafext_dsgvo' ) ) {
			wp_die( 'invalid', 404 );
		}
		if ( isset( $_POST['cookie'] ) ) {
			if ( $_POST['cookie'] !== '' ) {
				if ( $_POST['cookie'] === 'delete' ) {
					// https://www.php.net/manual/en/function.setcookie.php#125242
					$arr_cookie_options = array(
						'expires'  => time() - 60 * 60 * 24,
						'path'     => '/',
						'domain'   => wp_parse_url( get_site_url(), PHP_URL_HOST ),
						'secure'   => true,
						'httponly' => true,
						'samesite' => 'Strict', // None || Lax  || Strict
					);
					setcookie( 'leafext', time(), $arr_cookie_options );
					if ( isset( $_POST['origin'] ) ) {
						header( 'Location: ' . esc_url_raw( wp_unslash( $_POST['origin'] ) ) );
						exit;
					}
				}
			}
		}
	}
}
add_action( 'init', 'leafext_delete_cookie' );
