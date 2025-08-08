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

// Updates from Github
if ( ! function_exists( 'leafext_updates_from_github' ) ) {
	function leafext_updates_from_github() {
		echo '<h2>' . wp_kses_post( 'Updates in WordPress way' ) . '</h2>';
		if ( is_multisite() ) {
			if ( strpos(
				implode(
					',',
					array_keys(
						get_site_option( 'active_sitewide_plugins', array() )
					)
				),
				'leafext-update-github.php'
			) !== false ) {
						echo wp_kses_post(
							'To manage and receive updates, open <a href="' .
							get_site_url( get_main_site_id() ) .
							'/wp-admin/admin.php?page=github-settings">Github settings</a>.'
						);
			} else {
					echo wp_kses_post(
						'To receive updates, go to the <a href="' .
						esc_url( network_admin_url() ) .
						'plugins.php">network dashboard</a> and install and network activate ' .
						'<a href="https://github.com/hupe13/leafext-update-github">Updates for plugins from hupe13 hosted on Github</a>.'
					);
			}
		} elseif ( strpos(
			implode(
				',',
				get_option( 'active_plugins', array() )
			),
			'leafext-update-github.php'
		) !== false ) {
						echo wp_kses_post(
							'To manage and receive updates, open <a href="' .
							esc_url( admin_url() ) .
							'admin.php?page=github-settings">Github settings</a>.'
						);
		} else {
				echo wp_kses_post(
					'To receive updates, go to the <a href="' .
					esc_url( admin_url() ) .
					'plugins.php">dashboard</a> and install and activate ' .
					'<a href="https://github.com/hupe13/leafext-update-github">Updates for plugins from hupe13 hosted on Github</a>.'
				);
		}
	}
}
