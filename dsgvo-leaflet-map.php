<?php
/**
 * Plugin Name:       DSGVO snippet for Leaflet Map and its Extensions Github Version
 * Description:       Respect the DSGVO / GDPR when you use Leaflet Map and Extensions for Leaflet Map.
 * Plugin URI:        https://leafext.de/en/
 * Update URI:        https://github.com/hupe13/dsgvo-leaflet-map-github
 * Version:           260503
 * Requires PHP:      8.2
 * Requires Plugins:  leaflet-map
 * Author:            hupe13
 * Author URI:        https://leafext.de/en/
 * License:           GPL v2 or later
 * GitHub Plugin URI: https://github.com/hupe13/dsgvo-leaflet-map-github
 * Primary Branch:    main
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

define( 'LEAFEXT_DSGVO_PLUGIN_NAME', basename( __DIR__ ) ); // dsgvo-leaflet-map

if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
// string $plugin_file, bool $markup = true, bool $translate = true
$leafext_plugin_data = get_plugin_data( __FILE__, true, false );
define( 'LEAFEXT_DSGVO_PLUGIN_VERSION', $leafext_plugin_data['Version'] );

if ( ! function_exists( 'leafext_plugin_active' ) ) {
	function leafext_plugin_active( $slug ) {
		$plugins = get_option( 'active_plugins' );
		if ( is_array( $plugins ) ) {
			$is_active = preg_grep( '/^.*\/' . $slug . '\.php$/', $plugins );
			if ( count( $is_active ) === 1 ) {
				return true;
			}
		}
		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( is_array( $plugins ) ) {
			$is_active = preg_grep( '/^.*\/' . $slug . '\.php$/', array_flip( $plugins ) );
			if ( count( $is_active ) === 1 ) {
				return true;
			}
		}
		return false;
	}
}

// Add settings to plugin page
function leafext_add_action_dsgvo_links( $actions ) {
		$actions[] = '<a href="' . esc_url( admin_url( 'admin.php' ) . '?page=' . LEAFEXT_DSGVO_PLUGIN_NAME ) . '">' . esc_html__( 'Settings', 'dsgvo-leaflet-map' ) . '</a>';
		return $actions;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'leafext_add_action_dsgvo_links' );

require_once __DIR__ . '/php/leaflet-map.php';
require_once __DIR__ . '/php/shortcode.php';
require_once __DIR__ . '/php/time-delete.php';

if ( is_admin() ) {
	include_once __DIR__ . '/admin.php';
	include_once __DIR__ . '/admin/help.php';
}

// Disable activation the other of WP / Github Version
if ( ! function_exists( 'leafext_disable_dsgvo_activation' ) ) {
	function leafext_disable_dsgvo_activation( $actions, $plugin_file ) {
		if ( array_key_exists( 'activate', $actions ) ) {
			if ( basename( $plugin_file ) === basename( __FILE__ ) ) {
				$actions['activate'] = wp_strip_all_tags( $actions['activate'] );
			}
		}
		return $actions;
	}
}
add_filter( 'plugin_action_links', 'leafext_disable_dsgvo_activation', 10, 2 );

// Github
if ( is_admin() ) {
	require_once __DIR__ . '/github-backend-dsgvo.php';
}
