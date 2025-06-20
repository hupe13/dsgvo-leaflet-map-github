<?php
/**
 * Backend Menus
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions Github Version
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

// for translating, geklaut von PUC
function leafext_dsgvo_textdomain() {
	$domain  = 'dsgvo-leaflet-map';
	$locale  = apply_filters(
		'plugin_locale',
		( is_admin() && function_exists( 'get_user_locale' ) ) ? get_user_locale() : get_locale(),
		$domain
	);
	$mo_file = $domain . '-' . $locale . '.mo';
	$path    = realpath( __DIR__ ) . '/lang/';
	if ( $path && file_exists( $path ) ) {
		load_textdomain( $domain, $path . $mo_file );
	}
}
add_action( 'plugins_loaded', 'leafext_dsgvo_textdomain' );

if ( ! function_exists( 'leafext_get_repos' ) ) {
	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'github/github-functions.php';
}

if ( is_main_site() && ! function_exists( 'leafext_update_puc_error' ) ) {
	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'github/github-settings.php';
	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'github/github-check-update.php';
}
