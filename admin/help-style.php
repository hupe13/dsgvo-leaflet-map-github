<?php
/**
 * Help DSGVO for Styling
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

function leafext_dsgvo_css_help() {
	if ( is_singular() || is_archive() ) {
		$codestyle = '';
	} else {
		leafext_enqueue_admin();
		$codestyle = ' class="language-coffeescript"';
	}
	$text  = '<h3>';
	$text .= __( 'Styling', 'dsgvo-leaflet-map' );
	$text .= '</h3>';
	$text .= '<p>';
	$text .= __( 'You can use following classes to style the the text area and the buttons:', 'dsgvo-leaflet-map' );
	$text .= '</p>';
	$text .= '<ul style="max-width: 750px;">';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;">leafext-dsgvo</li>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;">submit </li>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;">leafext-dsgvo-submit</li>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;">dsgvo-delete-submit</li>';
	$text .= '</ul>';

	$text .= __( 'See also the content of', 'dsgvo-leaflet-map' ) . ' css/leafext-dsgvo.css .';

	$text .= '<h4>leafext-map</h4>';

	$text .= '<pre' . $codestyle . '><code' . $codestyle . '>';
	$text .= '&lt;div class="leafext-dsgvo" style="height:...px; width:100%; background: ..., url(...);" >' . "\n";
	$text .= '&lt;div style="width: 70%; max-height: 100%;">' . "\n";
	$text .= '&lt;form ...>' . "\n";
	$text .= '&lt;p>' . __( 'Setting of', 'dsgvo-leaflet-map' ) . ' ' . __( '"Text"', 'dsgvo-leaflet-map' ) . '&lt;/p>' . "\n";
	$text .= '&lt;p class="submit leafext-dsgvo-submit">' . __( 'Setting of', 'dsgvo-leaflet-map' ) . ' "' . __( 'Submit Button', 'dsgvo-leaflet-map' ) . '"&lt;/p>' . "\n";
	$text .= '&lt;/form>' . "\n";
	$text .= '&lt;/div>' . "\n";
	$text .= '&lt;/div></code></pre>';

	$text .= '<h4>leafext-cookie</h4>';

	$text .= '<p><pre' . $codestyle . '><code' . $codestyle . '>&#091;leafext-cookie text="..." okay="..."]' . "\n";
	$text .= '...' . "\n";
	$text .= '&#091;/leafext-cookie]</code></pre></p>';

	$text .= '<pre' . $codestyle . '><code' . $codestyle . '>&lt;form ...>' . "\n";
	$text .= '&lt;p class="leafext-dsgvo">'
	. __( 'Setting of', 'dsgvo-leaflet-map' ) . ' ' . __( '"Text"', 'dsgvo-leaflet-map' ) . ' ' . __( 'or option', 'dsgvo-leaflet-map' ) . ' text'
	. '&lt;/p>' . "\n";
	$text .= '&lt;p class="submit leafext-dsgvo-submit">'
	. __( 'Setting of', 'dsgvo-leaflet-map' ) . ' "' . __( 'Submit Button', 'dsgvo-leaflet-map' ) . '" ' . __( 'or option', 'dsgvo-leaflet-map' ) . ' okay'
	. '&lt;/p>' . "\n";
	$text .= '&lt;/form></code></pre>';

	$text .= '<h4>leafext-delete-cookie</h4>';

	$text .= '<p><pre' . $codestyle . '><code' . $codestyle . '>&#091;leafext-delete-cookie delete="..."]</code></pre></p>';

	$text .= '<pre' . $codestyle . '><code' . $codestyle . '>';
	$text .= '&lt;form ...>' . "\n";
	$text .= '&lt;div class="submit leafext-dsgvo-submit leafext-dsgvo-delete-submit">' . __( 'Content of WordPress "Delete" button or option', 'dsgvo-leaflet-map' ) . ' delete&lt;/div>' . "\n";
	$text .= '&lt;/form></code></pre>' . "\n";

	return $text;
}
