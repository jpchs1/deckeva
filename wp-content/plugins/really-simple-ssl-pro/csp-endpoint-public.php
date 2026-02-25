<?php
defined('ABSPATH') or die("you do not have access to this page!");

/**
 *
 * API for Content Security Policy registration
 * @Since 2.5
 *
 */

if ( rsssl_get_option('csp_status') === 'learning_mode' ) {
    add_action('rest_api_init', 'rsssl_pro_csp_rest_route');
}

if ( !function_exists('rsssl_pro_csp_rest_route')) {
	function rsssl_pro_csp_rest_route() {
		register_rest_route( 'rsssl/v1', 'csp/', array(
			'methods'             => 'POST',
			'callback'            => 'rsssl_track_csp',
			'permission_callback' => 'rsssl_pro_validate_api_call',
		) );
	}
}

/**
 * @param $request
 * @return bool
 *
 * Check if the requests' comes from own server
 * @since 4.1.4
 *
 */
if ( !function_exists('rsssl_pro_validate_api_call')) {
	function rsssl_pro_validate_api_call( $request ) {
		$origin = $request->get_header( 'host' );

		if ( $request->get_param( 'rsssl_apitoken' ) != get_site_option( 'rsssl_csp_report_token' ) ) {
			return false;
		}

		if ( strpos( site_url(), $origin ) !== false || strpos( home_url(), $origin ) !== false ) {
			//we're about to give access to the backend for this api call
			if ( ! defined( 'RSSSL_LEARNING_MODE' ) ) {
				define( 'RSSSL_LEARNING_MODE', true );
			}

			return true;
		} else {
			return false;
		}
	}
}

if ( !function_exists('rsssl_maybe_disable_learning_mode_after_period') ) {
	function rsssl_maybe_disable_learning_mode_after_period(){
		if ( rsssl_get_option( 'csp_status' )==='learning_mode' ) {
			//disable learning mode after one week
			$activation_time = get_site_option( 'rsssl_csp_report_only_activation_time' );
			$nr_of_days_learning_mode = apply_filters( 'rsssl_pause_after_days', 7 );
			$one_week_ago = strtotime( "-$nr_of_days_learning_mode days" );
			if ( $activation_time < $one_week_ago ) {
				//ensure the functions are included
				if ( !function_exists('rsssl_update_option' )) {
					require_once( rsssl_path . 'settings/settings.php' );
				}
				rsssl_update_option( 'csp_status', 'completed' );
			}
		}
	}
}

/**
 * @param WP_REST_Request $request
 *
 * @Since 2.5
 *
 * Process Content Security Policy violations, add to DB
 *
 * $blockeduri: the domain which is blocked due to content security policy rules
 * $documenturi: the post/page where the violation occurred
 *
 */
if (!function_exists('rsssl_track_csp')) {
	function rsssl_track_csp( WP_REST_Request $request ) {
		if ( $request->get_param( 'rsssl_apitoken' ) != get_site_option( 'rsssl_csp_report_token' ) ) {
			return;
		}

		//prevent more than one running at the same time.
		if ( get_transient("rsssl_csp_request_running") ) {
			return;
		}

		set_transient("rsssl_csp_request_running", true, 5 * MINUTE_IN_SECONDS );
		global $wpdb;
		$table_name = $wpdb->base_prefix . "rsssl_csp_log";
		$row_count = $wpdb->get_var( "SELECT count(*) FROM $table_name" );
		if ( $row_count >= 500 ) {
			return;
		}

		//CSP-report-only data is contained in php://input stream
		$json_data = file_get_contents( 'php://input' );
		$json_data = json_decode( $json_data, true );
		$blockeduri        = rsssl_sanitize_uri_value( $json_data['csp-report']['blocked-uri'] );
		$violateddirective = rsssl_sanitize_csp_violated_directive( $json_data['csp-report']['violated-directive'] );
		$documenturi       = esc_url_raw( $json_data['csp-report']['document-uri'] );
		// Remove query strings from $documenturi. strstr will return false if needle is not found. Therefore continue with $documenturi when strstr returns false
		$documenturi = strstr( $documenturi, '?', true ) ?: $documenturi;
		//If one of these is empty we cannot generate a CSP rule from it, return
		if ( !empty( $violateddirective ) && !empty( $blockeduri ) ) {
			//Check if the blockeduri and violatedirective already occur in DB. If so, we do not need to add them again.
			$count = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM $table_name where blockeduri = %s AND violateddirective=%s", $blockeduri, $violateddirective ) );
			if ( $count == 0 ) {
				$wpdb->insert( $table_name, array(
					'time'              => current_time( 'mysql' ),
					'documenturi'       => $documenturi,
					//Violateddirective and blockeduri are already sanitized earlier in this function
					'violateddirective' => $violateddirective,
					'blockeduri'        => $blockeduri,
					'status'            => 1, //default inserted.
				) );
			}
		}

		if ( !class_exists('rsssl_firewall_manager') ) {
			require_once( rsssl_path.'security/' . 'firewall-manager.php' );
			$firewall_manager = new rsssl_firewall_manager();
			$firewall_manager->insert_advanced_header_file();
		} else {
			do_action("rsssl_update_rules");
		}
		delete_transient("rsssl_csp_request_running");
	}
}

/**
 * @param string $str
 * @return string
 *
 * @Since 2.5
 *
 * Only allow known directives to be returned, otherwise return empty string
 *
 */
if ( !function_exists('rsssl_sanitize_csp_violated_directive')) {
	function rsssl_sanitize_csp_violated_directive( $str ) {
		//Style-src-elem and script-src-elem are implemented behind a browser flag. Therefore, save as style-src and script-src since these are used as a fallback
		if ( $str === 'style-src-elem' ) {
			//$str = str_replace('style-src-elem', 'style-src', $str);
		}

		if ( $str === 'script-src-elem' ) {
			//$str = str_replace('script-src-elem', 'script-src', $str);
		}

		//https://www.w3.org/TR/CSP3/#directives-fetch
		$directives = array(
			//Fetch directives
			'child-src',
			'connect-src',
			'default-src',
			'font-src',
			'frame-src',
			'img-src',
			'manifest-src',
			'media-src',
			'prefetch-src',
			'object-src',
			'script-src',
			'script-src-elem',
			'script-src-attr',
			'style-src',
			'style-src-elem',
			'style-src-attr',
			'worker-src',
			//Document directives
			'base-uri',
			'plugin-types',
			'sandbox',
			'form-action',
			'frame-ancestors',
			'navigate-to',
		);

		if ( in_array( $str, $directives ) ) {
			return $str;
		}

		//not found? check if it's part of the string
		foreach ( $directives as $directive ) {
			if ( strpos( $str, $directive ) !== false ) {
				return $directive;
			}
		}

		return '';
	}
}
/**
 * Only allow known directives to be returned, otherwise return empty string
 *
 * @param string $str
 * @return string
 *
 * @Since 2.5
 *
 */
if ( !function_exists('rsssl_sanitize_csp_blocked_uri')) {
	function rsssl_sanitize_csp_blocked_uri( $str ) {

		//Data: needs an : which isn't included automatically, add here
		if ( $str === 'data' ) {
			$str = str_replace( 'data', 'data:', $str );
		}

		//Inline should be unsafe-inline
		if ( $str === 'inline' ) {
			$str = str_replace( 'inline', 'unsafe-inline', $str );
		}

		//Eval should be unsafe - eval
		if ( $str === 'eval' ) {
			$str = str_replace( 'eval', 'unsafe-eval', $str );
		}

		if ( $str === 'unsafe-inline' ) {
			$str = str_replace( 'unsafe-inline', "'unsafe-inline'", $str );
		}

		if ( $str === 'unsafe-eval' ) {
			$str = str_replace( 'unsafe-eval', "'unsafe-eval'", $str );
		}

		$directives = array(
			//Fetch directives
			"self",
			'data:',
			"'unsafe-inline'",
			"'unsafe-eval'",
			"about",
		);

		if ( in_array( $str, $directives ) ) {
			return $str;
		}

		return '';
	}
}
/**
 * URI can be a domain or a value (e.g. data:). If it's a domain, return the main domain (https://example.com).
 * Otherwise return one of the other known uri value.
 *
 * @param string $blockeduri
 * @return string
 *
 * @since 2.5
 *
 */

if ( !function_exists('rsssl_sanitize_uri_value')) {
	function rsssl_sanitize_uri_value($blockeduri)
{
	$uri = '';

	//Check if uri starts with http(s)
	if (substr($blockeduri, 0, 4) === 'http') {
		$url = parse_url( $blockeduri );
		if ( ( isset( $url['scheme'] ) ) && isset( $url['host'] ) ) {
			$uri = esc_url_raw( $url['scheme'] . "://" . $url['host'] );
		}
		//allow for wss:// and ws:// websocket scheme
	} else if (substr($blockeduri, 0, 2) === 'ws') {
		$url = parse_url($blockeduri);
		if ( (isset($url['scheme'])) && isset($url['host']) ) {
			$uri = $url['scheme'] . "://" . $url['host'];
		}
	} else {
		$uri = rsssl_sanitize_csp_blocked_uri($blockeduri);
	}

	return $uri;
}
}