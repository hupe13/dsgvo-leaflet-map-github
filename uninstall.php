<?php
/**
 * Uninstall handler.
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 */

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

delete_option( 'leafext_dsgvo' );
