<?php
/**
 *  Admin DSGVO snippet for Leaflet Map and its Extensions
 *
 * @package DSGVO snippet for Leaflet Map and its Extensions
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

if ( leafext_plugin_active( 'extensions-leaflet-map' ) ) {
	// Add menu page
	function leafext_dsgvo_add_page() {
		// Add Submenu
		$leafext_admin_page = add_submenu_page(
			'leaflet-map',
			'Leaflet Map ' . __( 'Options GDPR', 'dsgvo-leaflet-map' ),
			'Leaflet Map ' . __( 'GDPR', 'dsgvo-leaflet-map' ),
			'manage_options',
			LEAFEXT_DSGVO_PLUGIN_NAME,
			'leafext_dsgvo_do_page'
		);
	}
	add_action( 'admin_menu', 'leafext_dsgvo_add_page', 90 );

	function leafext_dsgvo_init() {
		add_settings_section( 'leafext_dsgvo', '', '', 'leafext_settings_dsgvo' );
		$fields = leafext_dsgvo_params();
		foreach ( $fields as $field ) {
			add_settings_field(
				'leafext_dsgvo[' . $field['param'] . ']',
				$field['desc'],
				'leafext_dsgvo_form',
				'leafext_settings_dsgvo',
				'leafext_dsgvo',
				$field['param'],
			);
		}
		// https://stackoverflow.com/a/77545721
		$leafext_dsgvo = get_option( 'leafext_dsgvo' );
		if ( $leafext_dsgvo === false ) {
			add_option( 'leafext_dsgvo', '' );
		}
		register_setting( 'leafext_settings_dsgvo', 'leafext_dsgvo', 'leafext_validate_dsgvo' );
	}
	add_action( 'admin_init', 'leafext_dsgvo_init' );

	function leafext_dsgvo_form( $field ) {
		$options  = leafext_dsgvo_params();
		$option   = leafext_array_find3( $field, $options );
		$settings = leafext_dsgvo_settings();
		$setting  = $settings[ $field ];
		if ( leafext_plugin_active( 'polylang-theme-translation' ) ) {
			$ttfp = ' readonly ';
		} else {
			$ttfp = '';
		}
		switch ( $field ) {
			case 'text':
				echo '<textarea ' . esc_attr( $ttfp ) . ' name="leafext_dsgvo[text]" type="textarea" cols="80" rows="5">';
				echo wp_kses_post( $setting );
				echo '</textarea>';
				break;
			case 'mapurl':
				echo '<input type="url" size="80" name="leafext_dsgvo[mapurl]" value="' . esc_url( $setting ) . '" />';
				break;
			case 'color':
				leafext_dsgvo_colors( $option['default'], $setting );
				break;
			case 'cookie':
				echo '<input type="number" size="5" min="1" max="365" name="leafext_dsgvo[cookie]" value="' . absint( $setting ) . '"> ';
				esc_html_e( 'days', 'dsgvo-leaflet-map' );
				break;
			case 'count':
				echo '<input type="radio" name="leafext_dsgvo[count]" value="1" ';
				echo boolval( $setting ) ? 'checked' : '';
				echo '> ';
				esc_html_e( 'each map', 'dsgvo-leaflet-map' );
				echo ' &nbsp;&nbsp; ';
				echo '<input type="radio" name="leafext_dsgvo[count]" value="0" ';
				echo ! boolval( $setting ) ? 'checked' : '';
				echo '> ';
				esc_html_e( 'only first', 'dsgvo-leaflet-map' );
				echo ' ';
				break;
			case 'okay':
				echo '<input type="text" ' . esc_attr( $ttfp ) . ' size="80" name="leafext_dsgvo[okay]" value="' . esc_attr( $setting ) . '" />';
				break;
			default:
				wp_die( 'error' );
		}
	}

	// Sanitize and validate input. Accepts an array, return a sanitized array.
	function leafext_validate_dsgvo( $options ) {
		check_admin_referer( 'leafext_dsgvo', 'leafext_dsgvo_nonce' );
		if ( isset( $_POST['submit'] ) ) {
			$defaults = array();
			$params   = leafext_dsgvo_params();
			foreach ( $params as $param ) {
				$defaults[ $param['param'] ] = $param['default'];
			}
			if ( isset( $options['cookie'] ) && ( $options['cookie'] === '0' || $options['cookie'] === '' ) ) {
				$options['cookie'] = absint( $defaults['cookie'] );
			}
			if ( isset( $options['text'] ) ) {
				$options['text'] = wp_kses_post( $options['text'] );
			}
			if ( isset( $options['mapurl'] ) ) {
				$options['mapurl'] = sanitize_url( $options['mapurl'] );
			}
			if ( isset( $options['color'] ) ) {
				$options['color'] = sanitize_text_field( $options['color'] );
			}
			if ( isset( $options['count'] ) ) {
				$options['count'] = absint( $options['count'] );
			}
			if ( isset( $options['okay'] ) ) {
				$options['okay'] = sanitize_text_field( $options['okay'] );
			}
			$change = array();
			foreach ( $options as $key => $value ) {
				if ( $value !== $defaults[ $key ] ) {
					$change[ $key ] = $value;
				}
			}
			return $change;
		}
		if ( isset( $_POST['delete'] ) ) {
			delete_option( 'leafext_dsgvo' );
		}
		return false;
	}

	// Draw the menu page itself
	function leafext_dsgvo_do_page() {
		$tab        = filter_input(
			INPUT_GET,
			'tab',
			FILTER_CALLBACK,
			array( 'options' => 'esc_html' )
		);
		$active_tab = $tab ? $tab : 'help';

		echo '<div style="max-width: 1000px;">';

		leafext_admin_dsgvo_tabs();

		if ( strpos( $active_tab, 'shortcode' ) !== false ) {
			include_once LEAFEXT_DSGVO_PLUGIN_DIR . 'admin/help-shortcode.php';
			leafext_dsgvo_short_code_help();
		} elseif ( strpos( $active_tab, 'time-delete' ) !== false ) {
			include_once LEAFEXT_DSGVO_PLUGIN_DIR . 'admin/help-time-delete.php';
			leafext_dsgvo_time_delete_help();
		} elseif ( strpos( $active_tab, 'css' ) !== false ) {
			include_once LEAFEXT_DSGVO_PLUGIN_DIR . 'admin/help-style.php';
			echo wp_kses_post( leafext_dsgvo_css_help() );
		} else {
			if ( function_exists( 'leafext_dsgvo_updates_from_github' ) ) {
				leafext_dsgvo_updates_from_github();
			}
			leafext_dsgvo_main_help();
		}
		echo '</div>';
	}

	// Suche bestimmten Wert in array im admin interface
	function leafext_array_find3( $needle, $haystack ) {
		foreach ( $haystack as $item ) {
			if ( $item['param'] === $needle ) {
				return $item;
			}
		}
	}

	// Baue Abfrage Farben
	function leafext_dsgvo_colors( $defcolor, $value ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script(
			'wp-color-picker-alpha',
			plugins_url( '/js/wp-color-picker-alpha.min.js', __FILE__ ),
			array( 'wp-color-picker' ),
			LEAFEXT_DSGVO_PLUGIN_VERSION,
			true
		);
		wp_enqueue_script(
			'leafext-picker',
			plugins_url( '/js/colorpicker.js', __FILE__ ),
			array( 'wp-color-picker-alpha', 'wp-color-picker' ),
			LEAFEXT_DSGVO_PLUGIN_VERSION,
			true
		);

		echo '<input type="text" class="color-picker" id="leafext_dsgvo_color" name="leafext_dsgvo[color]" data-alpha-enabled="true" data-default-color="'
		. esc_attr( $defcolor ) . '" value="' . esc_attr( $value ) . '">';
	}

	function leafext_admin_dsgvo_tabs() {
		echo '<div class="wrap nothickbox">';
		leafext_dsgvo_help();
		echo '</div>' . "\n";

		$tab        = filter_input(
			INPUT_GET,
			'tab',
			FILTER_CALLBACK,
			array( 'options' => 'esc_html' )
		);
		$active_tab = $tab ? $tab : 'help';

		echo '<h3 class="nav-tab-wrapper">';
		echo '<a href="' . esc_url( '?page=' . LEAFEXT_DSGVO_PLUGIN_NAME . '&tab=help' ) . '" class="nav-tab';
		echo $active_tab === 'help' ? ' nav-tab-active' : '';
		echo '">' . esc_html__( 'Help', 'dsgvo-leaflet-map' ) . '</a>' . "\n";

		$tabs = array(
			array(
				'tab'   => 'shortcode',
				'title' => 'leafext-cookie',
			),
			array(
				'tab'   => 'time-delete',
				'title' => __( 'cookie-time & delete-cookie', 'dsgvo-leaflet-map' ),
			),
			array(
				'tab'   => 'css',
				'title' => __( 'Styling', 'dsgvo-leaflet-map' ),
			),
		);

		foreach ( $tabs as $tab ) {
			echo '<a href="' . esc_url( '?page=' . LEAFEXT_DSGVO_PLUGIN_NAME . '&tab=' . $tab['tab'] ) . '" class="nav-tab';
			$active = ( $active_tab === $tab['tab'] ) ? ' nav-tab-active' : '';
			if ( isset( $tab['strpos'] ) ) {
				if ( strpos( $active_tab, $tab['strpos'] ) !== false ) {
					$active = ' nav-tab-active';
				}
			}
			echo esc_attr( $active );
			echo '">' . esc_html( $tab['title'] ) . '</a>' . "\n";
		}
		echo '</h3>';
	}
}
