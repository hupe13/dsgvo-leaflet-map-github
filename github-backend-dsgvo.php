<?php
/**
 * Backend Menus
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions Github Version
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

// for translating a plugin
function leafext_dsgvo_textdomain() {
	if ( get_locale() === 'de_DE' ) {
		load_plugin_textdomain( 'leafext-update-github', false, LEAFEXT_DSGVO_PLUGIN_NAME . '/github/lang/' );
		load_plugin_textdomain( 'dsgvo-leaflet-map', false, LEAFEXT_DSGVO_PLUGIN_NAME . '/lang/' );
	}
}
add_action( 'plugins_loaded', 'leafext_dsgvo_textdomain' );

if ( ! function_exists( 'leafext_get_repos' ) ) {
	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'github/github-functions.php';
}

if ( is_main_site() ) {
	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'github/github-settings.php';
	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'github/github-check-update.php';
}
