<?php
/**
 * Plugin Name:       DSGVO snippet for Leaflet Map and its Extensions Github Version
 * Description:       Respect the DSGVO / GDPR when you use Leaflet Map and Extensions for Leaflet Map.
 * Plugin URI:        https://leafext.de/en/
 * Update URI:        https://github.com/hupe13/dsgvo-leaflet-map-github
 * Version:           250620
 * Requires PHP:      7.4
 * Requires Plugins:  leaflet-map, extensions-leaflet-map
 * Author:            hupe13
 * Author URI:        https://leafext.de/en/
 * License:           GPL v2 or later
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

define( 'LEAFEXT_DSGVO_PLUGIN_FILE', __FILE__ ); // /pfad/wp-content/plugins/dsgvo-leaflet-map/dsgvo-leaflet-map.php
define( 'LEAFEXT_DSGVO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); // /pfad/wp-content/plugins/dsgvo-leaflet-map/
define( 'LEAFEXT_DSGVO_PLUGIN_NAME', basename( LEAFEXT_DSGVO_PLUGIN_DIR ) ); // dsgvo-leaflet-map
define( 'LEAFEXT_DSGVO_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); // https://url/wp-content/plugins/dsgvo-leaflet-map/

if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
// string $plugin_file, bool $markup = true, bool $translate = true
$plugin_data = get_plugin_data( __FILE__, true, false );
define( 'LEAFEXT_DSGVO_PLUGIN_VERSION', $plugin_data['Version'] );

if ( ! function_exists( 'leafext_plugin_active' ) ) {
	function leafext_plugin_active( $slug ) {
		$plugins   = get_option( 'active_plugins' );
		$is_active = preg_grep( '/^.*\/' . $slug . '\.php$/', $plugins );
		if ( count( $is_active ) === 1 ) {
			return true;
		}
		return false;
	}
}

if ( leafext_plugin_active( 'extensions-leaflet-map' ) ) {
	// Add settings to plugin page
	function leafext_add_action_dsgvo_links( $actions ) {
		$actions[] = '<a href="' . esc_url( admin_url( 'admin.php' ) . '?page=' . LEAFEXT_DSGVO_PLUGIN_NAME ) . '">' . esc_html__( 'Settings', 'dsgvo-leaflet-map' ) . '</a>';
		return $actions;
	}
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'leafext_add_action_dsgvo_links' );

	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'php/leaflet-map.php';
	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'php/shortcode.php';
	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'php/time-delete.php';
}

if ( is_admin() ) {
	include_once LEAFEXT_DSGVO_PLUGIN_DIR . 'admin.php';
	include_once LEAFEXT_DSGVO_PLUGIN_DIR . 'admin/help.php';
}

// WP < 6.5, ClassicPress
function leafext_extensions_require() {
	if ( ! leafext_plugin_active( 'extensions-leaflet-map' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		$message = '<div><p>' . sprintf(
			/* translators: %s is a link. */
			esc_html__( 'Please install and activate %1$sExtensions for Leaflet Map%2$s before using DSGVO snippet for Leaflet Map and its Extensions.', 'dsgvo-leaflet-map' ),
			'<a href="https://wordpress.org/plugins/extensions-leaflet-map/">',
			'</a>'
		) . '</p><p><a href="' . esc_html( network_admin_url( 'plugins.php' ) ) . '">' .
			__( 'Manage plugins', 'dsgvo-leaflet-map' ) . '</a>.</p></div>';
		$error = new WP_Error(
			'error',
			$message,
			array(
				'title'    => __( 'Plugin Error', 'dsgvo-leaflet-map' ),
				'response' => '406',
			)
		);
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- it is an WP Error
		wp_die( $error, '', wp_kses_post( $error->get_error_data() ) );
	}
}
register_activation_hook( __FILE__, 'leafext_extensions_require' );

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
add_filter( 'plugin_action_links', 'leafext_disable_dsgvo_activation', 10, 4 );

// Github
if ( is_admin() ) {
	require_once LEAFEXT_DSGVO_PLUGIN_DIR . 'github-backend-dsgvo.php';
}
