<?php
/**
 * Help DSGVO for leafext-cookie-time and leafext-delete
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

function leafext_dsgvo_time_delete_help() {
	$text = '<h3>' . sprintf(
		/* translators: %s is leafext_cookie */
		__( 'Shortcodes %1$s and %2$s', 'dsgvo-leaflet-map' ),
		'leafext-cookie-time',
		'leafext-delete-cookie'
	) . '</h3>';
	if ( is_singular() || is_archive() ) {
		$codestyle = '';
	} else {
		leafext_enqueue_admin();
		$codestyle = ' class="language-coffeescript"';
	}

	$text .= sprintf(
		/* translators: %s are leafext-cookie-time and leafext-delete-cookie */
		__( '%1$s shows the time when the cookie was set and %2$s displays a button to delete the cookie.', 'dsgvo-leaflet-map' ),
		'<code>leafext-cookie-time</code>',
		'<code>leafext-delete-cookie</code>'
	);

	$text .= '<h3>Code</h3>';
	$text .= '<p><pre' . $codestyle . '><code' . $codestyle . '>&#091;leafext-cookie-time gmt=0/1 format="..." before="..." after="..." unset="..."]</code></pre></p>';
	$text .= '<p><pre' . $codestyle . '><code' . $codestyle . '>&#091;leafext-delete-cookie button="..." before="..." after="..." unset="..."]</code></pre></p>';
	$text .= '<p><pre' . $codestyle . '><code' . $codestyle . '>&#091;leafext-delete-cookie link="..." before="..." after="..." unset="..."]</code></pre></p>';

	$text .= '<h3>' . __( 'Options', 'dsgvo-leaflet-map' ) . '</h3>';

	$text .= '<p><ul>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;"><code>gmt</code> - ' . __( 'Optional. Local time of the web server (default) or GMT time', 'dsgvo-leaflet-map' ) . '</li>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;"><code>format</code> - ' .
	sprintf(
		/* translators: %s are leafext-cookie-time and leafext-delete-cookie */
		__( 'Date and time format, see %1$sCustomize date and time format%2$s.', 'dsgvo-leaflet-map' ),
		'<a href="https://wordpress.org/documentation/article/customize-date-and-time-format/">',
		'</a>'
	) . '</li>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;"><code>button</code> - '
	. __( 'Optional. Text of submit button. Default: Content of WordPress "Delete" button.', 'dsgvo-leaflet-map' ) . '</li>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;"><code>link</code> - '
	. __( 'Optional. Display instead a submit button a link with the content.', 'dsgvo-leaflet-map' ) . '</li>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;"><code>before</code> - '
	. sprintf(
		/* translators: %s is "link" */
		__( 'extra text to display before date and time or %s.', 'dsgvo-leaflet-map' ),
		'<code>link</code>'
	) . '</li>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;"><code>after</code> - '
	. sprintf(
		/* translators: %s is "link" */
		__( 'extra text to display after date and time or %s.', 'dsgvo-leaflet-map' ),
		'<code>link</code>'
	) . '</li>';
	$text .= '<li style="list-style-type:disc;margin-left: 1.5em;"><code>unset</code> - '
	. __( 'text to display if the cookie is not set.', 'dsgvo-leaflet-map' ) . '</li>';
	$text .= '</ul></p>';

	$text .= '<h3><a href="https://leafext.de/extra/dsgvo-cookie/">' . __( 'Examples', 'dsgvo-leaflet-map' ) . '</a></h3>';

	if ( is_singular() || is_archive() ) {
		return $text;
	} else {
		echo wp_kses_post( $text );
	}
}
