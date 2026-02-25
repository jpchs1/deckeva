<?php defined('ABSPATH') or die();

class rsssl_headers {

	private static $_this;
	public $security_headers;
	public $directives;
	function __construct()
	{
		if (isset(self::$_this))
			wp_die(sprintf(__('%s is a singleton class and you cannot create a second instance.', 'really-simple-ssl'), get_class($this)));

		self::$_this = $this;
		// Key must match rsssl_recommended_security_headers filter in free
		$this->security_headers = apply_filters( 'rsssl_pro_detected_security_headers', array(
			[
				'name' => 'Upgrade Insecure Requests',
				'pattern' =>  ['header'=>'Content-Security-Policy', 'value' => 'upgrade-insecure-requests'],
				'option_name' => 'rsssl_upgrade_insecure_requests',
				'option_value' => 'upgrade-insecure-requests',
			],
			[
				'name' => 'Content Security Policy',
				'pattern' =>  ['header'=>'Content-Security-Policy', 'value' => false],
				'option_name' => 'rsssl_content_security_policy',
				'option_value' => false,
			],
			[
				'name' => 'X-XSS protection',
				'pattern' =>  ['header'=>'X-XSS-Protection', 'value' => false],
				'option_name' => 'rsssl_x_xss_protection',
				'option_value' => '0',
			],
			[
				'name' => 'X-Content Type Options',
				'pattern' =>  ['header'=>'X-Content-Type-Options', 'value' => false],
				'option_name' => 'rsssl_x_content_type_options',
				'option_value' => 'nosniff',
			],
			[
				'name' => 'Referrer-Policy',
				'pattern' =>  ['header'=>'Referrer-Policy', 'value' => false],
				'option_name' => 'referrer_policy',
				'option_value' => 'strict-origin-when-cross-origin',
			],
			[
				'name' => 'Permissions-Policy',
				'pattern' =>  ['header'=>'Permissions-Policy', 'value' => false],
				'option_name' => 'rsssl_turn_on_permissions_policy',
				'option_value' => false,
			],
			[
				'name' => 'X-Frame-Options',
				'pattern' =>  ['header'=>'X-Frame-Options', 'value' => false],
				'option_name' => 'rsssl_x_frame_options',
				'option_value' => 'SAMEORIGIN',
			],
			[
				'name' => 'HTTP Strict Transport Security Preload',
				'pattern' =>  ['header'=>'Strict-Transport-Security', 'value' => 'preload'],
				'option_name' => 'rsssl_hsts_preload',
				'option_value' => 'max-age=63072000; includeSubDomains; preload',
			],
			[
				'name' => 'HTTP Strict Transport Security',
				'pattern' =>  ['header'=>'Strict-Transport-Security', 'value' => false],
				'option_name' => 'rsssl_hsts',
				'option_value' => array('max-age=31536000', 'max-age=63072000; includeSubDomains; preload'),
			]
		));

		add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );
		add_filter('rsssl_firewall_rules', array($this, 'insert_security_headers'));
		add_action( "rsssl_after_save_field", array($this, 'save_time_on_report_only_start'), 100, 4 );
		add_action( "admin_init", array($this, 'store_csp_endpoint'), 100 );
		add_action( "update_option_permalink_structure", array($this, 'update_csp_endpoint'), 10, 2 );
		add_filter( 'rsssl_notices', array($this,'get_notices_list'),20, 1 );

		// Security header option update hooks
		//@todo Header detection disabled, enable in future version
//		add_filter( "pre_update_option", array( $this, "check_if_option_disabled_by_user" ), 4, 3 );
//      add_filter( 'rsssl_notices', array( $this, 'add_non_recommended_header_notices') );
//		add_action( 'admin_init', array($this, 'maybe_redirect_to_recheck_headers'), 999 );
		$this->directives = array(
			'child-src'         => "child-src 'self' {uri}; ",
			'connect-src'       => "connect-src 'self' {uri}; ",
			'font-src'          => "font-src 'self' {uri}; ",
			'frame-src'         => "frame-src 'self' {uri}; ",
			'img-src'           => "img-src 'self' data: {uri}; ",
			'manifest-src'      => "manifest-src 'self' {uri}; ",
			'media-src'         => "media-src 'self' {uri}; ",
			'prefetch-src'      => "prefetch-src 'self' {uri}; ",
			'object-src'        => "object-src 'self' {uri}; ",
			'script-src'        => "script-src 'self' 'unsafe-inline' {uri}; ",
			'script-src-elem'   => "script-src-elem 'self' 'unsafe-inline' {uri}; ",
			'script-src-attr'   => "script-src-attr 'self' {uri}; ",
			'style-src'         => "style-src 'self' 'unsafe-inline' {uri}; ",
			'style-src-elem'    => "style-src-elem 'self' 'unsafe-inline' {uri}; ",
			'style-src-attr'    => "style-src-attr 'self' {uri}; ",
			'worker-src'        => "worker-src 'self' {uri}; ",
		);
		if ( $this->is_settings_page() ) {
			delete_transient('rsssl_admin_notices');
			//start new check right away
			//without parameter clears data
			//@todo Header detection disabled, enable in future version
			//add_action('plugins_loaded', array($this, 'get_detected_security_headers') );
		}
	}

	static function this()
	{
		return self::$_this;
	}


	/**
	 * Get a list of headers that were enabled, but not detected
	 * @return array
	 *              //@todo Header detection disabled, enable in future version
	 */
//    public function undetected_enabled_headers(){
//        $security_headers = $this->security_headers;
//	    $set_but_not_detected = [];
//	    $unused_headers = RSSSL_PRO()->headers->get_detected_security_headers('un_used');
//	    foreach ( $security_headers as $header ) {
//		    if ( in_array($header['name'], $unused_headers) && rsssl_get_option( $header['option_name'] ) ){
//			    $set_but_not_detected[] = $header['name'];
//		    }
//	    }
//        return $set_but_not_detected;
//    }

	/**
	 * Check the configuration for the headers
	 * @todo Header detection disabled, enable in future version
	 * @return bool|string
	 */
//    public function all_enabled_headers_are_detected() {
//	     $php_headers = true;
//
//	    $set_but_not_detected = $this->undetected_enabled_headers();
//        //headers that were set, but not detected.
//        if ( count( $set_but_not_detected ) > 0 && $this->site_uses_cache() && $php_headers === false ) {
//            return 'enable_advanced_headers';
//        } else {
//            //al headers that are set, or we can't do anything about it, as php headers are already enabled, were detected.
//            return true;
//        }
//    }
//@todo Header detection disabled, enable in future version
//    public function security_headers_disabled_by_user_set_by_thirdparty_condition(){
//        $h = $this->security_headers_disabled_by_user_set_by_thirdparty();
//        return !empty($h);
//    }

	/**
	 * Check which headers are still enabled after disabling the option
	 *             //@todo Header detection disabled, enable in future version
	 */
//	public function security_headers_disabled_by_user_set_by_thirdparty() {
//		// When disabled and header has been set by host/server
//		$disabled_by_user_but_set = get_option('rsssl_security_headers_set_by_host_disabled_by_user', []);
//		$headers_set_by_thirdparty = RSSSL_PRO()->admin->get_active_security_headers_set_by_thirdparty();
//        $headers_still_enabled = array();
//        foreach ( RSSSL_PRO()->admin->security_headers as $header ) {
//            if ( array_key_exists( $header['name'], $headers_set_by_thirdparty )
//                 && ( $disabled_by_user_but_set && in_array( $header['option_name'], $disabled_by_user_but_set ) )
//                 && ! in_array( $header['name'], $headers_still_enabled ) ) {
//	                $headers_still_enabled[] = $header['name'];
//            }
//        }
//
//		return $headers_still_enabled;
//	}

	/**
	 *  When disabled by user, X-XSS-Protection is disabled and not set by third party, we show a notice that XSS should be enabled with setting 0
	 *
	 * @return false|string
	 */
//
//	public function x_xss_protection_status() {
//		if ( get_option('rsssl_xss_protection_disabled_by_user') ) {
//			return 'x-xss-disabled';
//		}
//
//		return false;
//	}

	/**
	 * Centralized method to check for several possible ways in which a value can be enabled.
	 * @param $value
	 *
	 * @return bool
	 *
	 */
	public function option_is_enabled($value){
		if ( !$value ) {
			return false;
		}
		return true;
	}

	/**
	 * Get list of notices for the dashboard
	 * @param array $notices
	 *
	 * @return array
	 */
	public function get_notices_list($notices)
	{
		unset($notices['recommended_security_headers_not_set']);
		//@todo Header detection disabled, enable in future version
//        $enabled_but_not_detected = $this->undetected_enabled_headers();
//		$enabled_but_not_detected = implode('<br>', $enabled_but_not_detected);
//		$enabled_but_not_detected = "<br><code style='padding: 0;'>" . $enabled_but_not_detected . "</code>";

//        $notices['recommended_security_headers_not_set'] = array(
//            'callback'  => 'RSSSL_PRO()->admin->all_enabled_headers_are_detected',
//            'condition' => array( 'rsssl_ssl_enabled' ),
//            'score'     => 0,
//            'output'    => array(
//                'enable_advanced_headers'=> array(
//                    'msg'         => __( "Not all enabled security headers have been detected. Please enable the option 'advanced-headers.php' in the setting 'How to set the security headers'.", "really-simple-ssl-pro" )
//                                     . $enabled_but_not_detected,
//                    'icon' => 'open',
//                    'url' => 'https://really-simple-ssl.com/how-to-set-security-headers-on-apache-and-nginx/',
//                    'dismissible' => true
//                ),
//            ),
//        );

		$notices['hsts_preload'] = array(
			'condition' => array('rsssl_ssl_enabled'),
			'callback' => 'RSSSL_PRO()->headers->hsts_status',
			'score' => 10,
			'output' => array(
				'preload' => array(
					'title' => __("HSTS Preload", "really-simple-ssl-pro"),
					'msg' => sprintf(__("Your site has been configured for the HSTS preload list. If you have submitted your site, it will be preloaded. Click %shere%s to submit.", "really-simple-ssl-pro"),'<a target="_blank" href="https://hstspreload.org/?domain='.$this->non_www_domain().'">', '</a>' ),
					'icon' => 'success'
				),
				'no_preload' => array(
					'highlight_field_id' => 'hsts_preload',
					'title' => __("HSTS Preload", "really-simple-ssl-pro"),
					'msg' => __("Your site is not yet configured for the HSTS preload list.", "really-simple-ssl-pro"),
					'icon' => 'open',
					'dismissible' => true,
				),
				'no_hsts' => array(
					'highlight_field_id' => 'hsts',
					'title' => __("HSTS not enabled", "really-simple-ssl-pro"),
					'msg' => __("Your site is not configured for HSTS yet.", "really-simple-ssl-pro"),
					'icon' => 'open',
					'dismissible' => true,
				),
			),
		);

//		$notices['x_xss_protection_disabled'] = array(
//			'callback' => 'RSSSL_PRO()->headers->x_xss_protection_status',
//			'score' => 10,
//			'output' => array(
//				'x-xss-disabled' => array(
//					'highlight_field_id' => 'x_xss_protection',
//					'msg' => __('You have disabled the X-XSS-Protection header. We recommend to enable the setting, this will set the X-XSS-Protection header to "0" (disable XSS filter). Disabling this option will remove the header and leave your site vulnerable to XSS and sidechannel attacks for users that use IE or Safari.',"really-simple-ssl-pro"),
//					'icon' => 'open',
//					'dismissible' => true,
//				),
//			),
//		);

		//@todo Header detection disabled, enable in future version
//        $notices['security_headers_disabled_by_user_set_by_thirdparty'] = array(
//            'callback' => 'RSSSL_PRO->headers->security_headers_disabled_by_user_set_by_thirdparty_condition',
//            'score' => 10,
//            'output' => array(
//                'true' => array(
//                    'url' => "https://really-simple-ssl.com/how-to-find-where-security-headers-are-set/",
//                    'msg' => sprintf(__('You tried to disable %s, but this is not possible because it is set by a third party. Re-saving will dismiss the notice.',"really-simple-ssl-pro"), implode( ', ' , RSSSL_PRO->headers->security_headers_disabled_by_user_set_by_thirdparty() )),
//                    'icon' => 'open',
//                    'dismissible' => false,
//                ),
//            ),
//        );

		return $notices;
	}

	/**
	 * Clear the headers
	 * @return void
	 */
	public function remove_advanced_headers() {
		if ( !defined('rsssl_plugin') ) {
			return;
		}
		//update with cleared options
		$disable = [
			"csp_frame_ancestors",
			"upgrade_insecure_requests",
			"enable_permissions_policy",
			"mixedcontentscan",
			"cross_origin_opener_policy",
			"hsts",
			"referrer_policy",
			"x_frame_options",
			"x_content_type_options",
			"x_xss_protection",
			"content_security_policy",
			"csp_status",
		];
		foreach ($disable as $name){
			rsssl_update_option($name, false);
		}
		RSSSL_SECURITY()->firewall_manager->insert_advanced_header_file();
	}

	/**
	 * Get HSTS status
	 * @return string|void
	 */
	public function hsts_status() {
		if ( !rsssl_get_option( 'hsts' ) ) {
			return 'no_hsts';
		} else if ( ( rsssl_get_option('hsts') && !rsssl_get_option( 'hsts_preload' ) ) ) {
			return 'no_preload';
		} else {
			return 'preload';
		}
	}

	/**
	 *
	 * Check if one of the security headers option has been cosmetically enabled by RSSSL, and keep track if it was enabled by the user.
	 *
	 * @param $value
	 * @param $old_value
	 * @param $option
	 *            //@todo Header detection disabled, enable in future version
	 * @return void
	 */
//	public function check_if_option_disabled_by_user( $value, $option, $old_value ) {
//        //if this is not posted by the user (save action) we skip
//        if ( !isset($_POST['option_page']) ) {
//            return $value;
//        }
//
//        $option_names = array_column($this->security_headers, 'option_name');
//        if ( in_array($option, $option_names) ) {
//            if ( $option==='rsssl_content_security_policy') {
//                return $value;
//            }
//	        $headers_set_by_thirdparty = $this->get_active_security_headers_set_by_thirdparty();
//	        $disabled_by_user = get_option('rsssl_security_headers_set_by_host_disabled_by_user', [] );
//	        if ( in_array( $option, $disabled_by_user) ) {
//		        $key = array_search($option, $disabled_by_user);
//		        unset($disabled_by_user[$key]);
//	        }
//
//	        //this header is not set by really simple ssl.
//	        if ( in_array( $option, $headers_set_by_thirdparty )  ) {
//		        //this header is not set by really simple ssl, but user is trying to disable it. Give a notice about it
//		        if ( !$this->option_is_enabled($value) && !in_array( $option, $disabled_by_user) ) {
//			        $disabled_by_user[] = $option;
//		        }
//		        $value = false;
//            //xss is a special case, as it has to be set preferably by us, with the 0 option.
//	        } else if ( $option === 'rsssl_x_xss_protection') {
//                if (!$value ) {
//	                update_option('rsssl_xss_protection_disabled_by_user', true, false );
//                } else {
//	                delete_option('rsssl_xss_protection_disabled_by_user', false );
//                }
//            }
//	        update_option('rsssl_security_headers_set_by_host_disabled_by_user', $disabled_by_user);
//        }
//
//        return $value;
//	}


	/**
	 * Check if this option is enabled by a third party
	 * @param $option
	 *            //@todo Header detection disabled, enable in future version
	 * @return bool
	 */
//    public function security_header_is_set_by_thirdparty( $option ){
//        $headers_set_by_thirdparty = $this->get_active_security_headers_set_by_thirdparty();
//	    if ( in_array($option, $headers_set_by_thirdparty) ){
//		     return true;
//	    }
//        return false;
//    }

	/**
	 * Get active security headers not set by RSSSL
	 * @return array header_name -> option_name
	 *                           //@todo Header detection disabled, enable in future version
	 */
//    public function get_active_security_headers_set_by_thirdparty() {
//        $found_not_enabled_by_rsssl = [];
//        // Get used headers
//        $used_headers = RSSSL_PRO()->headers->get_detected_security_headers( 'used' );
//        error_log("USED headers ");
//        error_log(print_r($used_headers, true));
//	    $security_header_names = array_column($this->security_headers, 'name');
//	    error_log("security_header_names ");
//	    error_log(print_r($security_header_names, true));
//		    foreach ( $used_headers as $header_name => $v ) {
//			    $found_key = array_search( $header_name, $security_header_names);
//                error_log("found key for $header_name $found_key");
//			    if ( $found_key!==FALSE ) {
//                    error_log($this->security_headers[ $found_key ]['option_name']);
//                    $found_not_enabled_by_rsssl[ $header_name ] = $this->security_headers[ $found_key ]['option_name'];
//			    }
//		    }
//
//	    return $found_not_enabled_by_rsssl;
//    }

	/**
	 * Add notice(s) for headers with non-recommended values
	 *
	 * @return array
	 * @todo Header detection disabled, enable in future version
	 */

//    public function add_non_recommended_header_notices( $notices ) {
//        //currently disabled
//        return $notices;
//
//	    $non_recommended_values = array();
//	    if ( RSSSL_PRO()->headers->is_header_check_running() ) {
//		    return $notices;
//	    }
//
//	    $used_headers = RSSSL_PRO()->headers->get_detected_security_headers( 'used' );
//        $security_header_names = array_column($this->security_headers, 'name');
//	    foreach ( $used_headers as $header_name => $header_value ) {
//            error_log("used headers");
//            error_log($header_name);
//		    // Skip CORS && CSP
//		    if ( $header_name === 'Cross-Origin-Opener-Policy' || $header_name === 'Cross-Origin-Resource-Policy') continue;
//
//            $found_key = array_search($header_name, $security_header_names);
//            if (isset( $header_value['value'] )) {
//                error_log("header value isset");
//            } else {
//                error_log("header value not set");
//            }
//		    if ( $this->security_headers[ $found_key ]['option_value']!==false ) {
//			    error_log("has option value ");
//                error_log(print_r($this->security_headers[ $found_key ]['option_value'], true));
//		    } else {
//                error_log("not has option value ");
//		    }
//            if ($found_key){
//                error_log("found key ".$found_key);
//            } else {
//                error_log("not found key ");
//            }
//
//		    if ( isset( $header_value['value'] ) && $this->security_headers[ $found_key ]['option_value']!==false && $found_key ) {
//			    $option_value = $this->security_headers[ $found_key ]['option_value'];
//                if ( !is_array($option_value) ) $option_value = [$this->security_headers[ $found_key ]['option_value']];
//                error_log("Check recommended value for ".$header_name);
//                error_log("actual value");
//                error_log(print_r($header_value['value'], true));
//
//			    error_log("recommended value");
//			    error_log(print_r($option_value, true));
//
//			    if ( !in_array($header_value['value'], $option_value) )  {
//				    // Value is different from recommended value
//				    $non_recommended_values[ $header_name ] = $header_value['value'];
//			    }
//		    }
//	    }
//
//        foreach ( $non_recommended_values as $header => $value ) {
//            $notices[ 'wrong_value_'.$header ] = array(
//                'callback' => '_true_',
//                'score' => 5,
//                'output' => array(
//                    'true' => array(
//	                    'url' => "https://really-simple-ssl.com/how-to-find-where-security-headers-are-set/",
//	                    'msg' => sprintf(__("Header %s has been set to non-recommended value: %s.", "really-simple-ssl-pro"), $header, $value ),
//                        'icon' => 'open',
//                        'dismissible' => true
//                    ),
//                ),
//            );
//        }
//	        $duplicate_headers=[];
//            //for php and advanced headers, the used headers ONLY contains headers that are not set by RSSSL.
//            //if any of these headers is also enabled in RSSSL, this is a duplicate header.
//	        foreach ( $used_headers as $header_name => $header_value ) {
//		        // Skip CORS && CSP
//		        if ( $header_name === 'Cross-Origin-Opener-Policy' || $header_name === 'Cross-Origin-Resource-Policy') continue;
//                error_log("Set by third party. Check if $header_name is set by RSSSL as well. ");
//		        $found_key = array_search($header_name, $security_header_names);
//		        if ( $found_key !== FALSE ) {
//			        $option_name = $this->security_headers[ $found_key ]['option_name'];
//                    $option_value = rsssl_get_option($option_name);
//			        if ( $this->option_is_enabled($option_value) ) {
//                        error_log("header $option_name is set by RSSSL");
//				        // Header is set both by third party and Really Simple SSL
//				        $duplicate_headers[ $header_name ] = $header_value['value'];
//			        } else {
//				        error_log("header $option_name is NOT set by RSSSL");
//			        }
//		        }
//	        }
//	        foreach ( $duplicate_headers as $header => $value ) {
//		        $notices[ 'duplicate_header_'.$header ] = array(
//			        'callback' => '_true_',
//			        'score' => 5,
//			        'output' => array(
//				        'true' => array(
//					        'url' => "https://really-simple-ssl.com/how-to-find-where-security-headers-are-set/",
//					        'msg' => sprintf(__("Duplicate Security Header detected: %s. This can cause conflicts between the two set headers.", "really-simple-ssl-pro"), $header ),
//					        'icon' => 'open',
//					        'dismissible' => false,
//				        ),
//			        ),
//		        );
//	        }
//
//        return $notices;
//    }


	/**
	 * If csp reporting is enabled, save the time so we track how long it's running
	 * @return void
	 */
	public function save_time_on_report_only_start($field_id, $field_value, $prev_value, $field_type ){
		if ( $field_id==='csp_status' && $field_value==='learning_mode' ){
			update_site_option("rsssl_csp_report_only_activation_time", time() );
		}
	}

	/**
	 * Retrieving it in the firewall update is too early for WP, so we store it here
	 * @return void
	 */
	public function store_csp_endpoint(): void {
		if ( !get_option('rsssl_csp_report_url') ) {
			update_option('rsssl_csp_report_url', get_rest_url(null, 'rsssl/v1/csp'), false );
		}
	}

	/**
	 * Update the rest URL if the permalink structure is changed
	 *
	 * @param string $old_value
	 * @param string $new_value
	 *
	 * @return void
	 */
	public function update_csp_endpoint( string $old_value, string $new_value): void {
		if ( $new_value !== $old_value ) {
			update_option('rsssl_csp_report_url', get_rest_url(null, 'rsssl/v1/csp'), false );
		}
	}

	/**
	 * Check for www
	 *
	 * @return array|string|string[]
	 */
	public function non_www_domain(){
		return str_replace(array("https://", "http://", "https://www.", "http://www.", "www."), "", get_home_url() );
	}

	/**
	 * This class has it's own settings page, to ensure it can always be called
	 *
	 * @return bool
	 */
	public function is_settings_page(): bool {
		if ( rsssl_is_logged_in_rest()){
			return true;
		}

		if (isset($_GET["page"]) && ($_GET["page"] == "really-simple-security" || $_GET["page"] == "really-simple-ssl") ) {
			return true;
		}

		return false;
	}

	/**
	 * Get CSP rules for any type or output type
	 *
	 * @return string
	 */
	public function get_csp_rules( ): string {
		//script-src-elem 'self' 'unsafe-inline' https://goingtoamerica.nl http://pvcsd.org; style-src 'self' https://fonts.googleapis.com 'unsafe-inline';
		global $wpdb;
		$header = 'Content-Security-Policy';

		$rules = '';
		if (rsssl_get_option('csp_status')==='enforce' || rsssl_get_option('csp_status')==='learning_mode') {
			//The base content security policy rules, used in later functions to generate the Content Security Policy
			$rules_array = [
				'img-src'         => "img-src 'self' data: ;",
				'default-src'     => "default-src 'self';",
				'script-src'      => "script-src 'self' 'unsafe-inline' 'unsafe-eval';",
				'script-src-elem' => "script-src-elem 'self' 'unsafe-inline';",
				'style-src'       => "style-src 'self' 'unsafe-inline';",
				'style-src-elem'  => "style-src-elem 'self' 'unsafe-inline';",
			];

			$table_name = $wpdb->base_prefix . "rsssl_csp_log";
			$rows = $wpdb->get_results("SELECT * FROM $table_name ORDER BY time DESC");
			if ( !empty($rows) ) {
				foreach ($rows as $row) {
					if ( $row->status == 1 ) {
						$violatedirective = $row->violateddirective;
						$blockeduri = $row->blockeduri;
						//Get uri value
						$uri = rsssl_sanitize_uri_value($blockeduri);
						//Generate CSP rule based on input
						$rules_array = $this->generate_csp_rule($violatedirective, $uri, $rules_array);
					}
				}
			}

			$rules = implode(" ", $rules_array);
			if ( rsssl_get_option('csp_status') === 'learning_mode' ) {
				$csp_violation_endpoint = get_option('rsssl_csp_report_url');
				$token = get_site_option('rsssl_csp_report_token');
				if ( !$token ) {
					$token = rand(1000, 999999999);
					update_site_option('rsssl_csp_report_token', $token);
				}
				//allow for fallback method
				if ( strpos($csp_violation_endpoint, '?') === false ) {
					$csp_violation_endpoint .= "?rsssl_apitoken=$token";
				} else {
					$csp_violation_endpoint .= "&rsssl_apitoken=$token";
				}
				//report-uri is deprecated, but report-to not yet supported widely
	//			$header = 'Report-To';
	//			$csp_endpoint_rules = "{'url': '".$csp_violation_endpoint."', 'group': 'csp-endpoint', 'max-age': 10886400}";
	//			$report_to_header = $this->wrap_header($header, $csp_endpoint_rules);
				$header = 'Content-Security-Policy-Report-Only';
	//			$rules =  "$rules report-uri $csp_violation_endpoint?rsssl_apitoken=$token; report-to csp-endpoint";
				$rules =  "$rules report-uri $csp_violation_endpoint;";
			}
		}

		# no upgrade insecure requests in report only mode
		if ( rsssl_get_option('csp_status') !== 'learning_mode' && rsssl_get_option('upgrade_insecure_requests') ) {
			$rules = "upgrade-insecure-requests; $rules";
		}

		if ( rsssl_get_option('csp_frame_ancestors') ==='none' || rsssl_get_option('csp_frame_ancestors') ==='self' )  {
			if ( rsssl_get_option('csp_frame_ancestors')==='none' ) {
				$rules = "frame-ancestors 'none';".$rules;
			} else {
				$urls = trim(rsssl_get_option('csp_frame_ancestors_urls'));
				if ( !empty($urls) ) {
					$urls = explode(",",$urls);
					$urls = array_map('trim', $urls);
					$urls = array_map('esc_url_raw', $urls);
					$urls = implode(" ", $urls);
				}
				$rules = "frame-ancestors 'self' $urls;".$rules;
			}
		}

		if ( !empty($rules) ) {
			return $this->wrap_header($header, $rules);
		}

		return '';
	}

	/**
	 * Generate security headers, and insert in .htaccess file
	 *
	 * @param string $rules
	 *
	 * @return string
	 */
	public function insert_security_headers( string $rules ): string {
		$rule = '';
		$break = "\n";
		$rule .= 'if ( !headers_sent() ) {'.$break;
		if ( is_ssl() && rsssl_get_option( 'hsts' ) ) {
			$subdomains = rsssl_get_option( 'hsts_subdomains' ) ? " includeSubDomains;" : "";
			$preload = rsssl_get_option("hsts_preload") ? "preload":"";
			$max_age = rsssl_get_option( 'hsts_max_age', '31536000');
			# only add hsts when on SSL
			# the advanced headers file will be included after the RSSSL fixes, so we should also have a server_https var if the host does not provide any of the default ones
			# wordpress is_ssl is not available yet, so we need our own
			# In some cases, even if the $_SERVER['HTTPS'] variable is available in WordPress, it might not yet be defined here. So we do a generic check.
			

			$rule .= 'function rsssl_is_ssl() {'.$break;
			$rule .= '  if (';
			$rule .= '  ( isset($_SERVER["HTTPS"]) && ("on" === $_SERVER["HTTPS"] || "1" === $_SERVER["HTTPS"]) )' . "\n";
			$rule .= '  || (isset($_ENV["HTTPS"]) && ("on" === $_ENV["HTTPS"]))' . "\n";
			$rule .= '  || (isset($_SERVER["SERVER_PORT"]) && ( "443" === $_SERVER["SERVER_PORT"] ) )' . "\n";
			$rule .= '  || (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "1") !== false))' . "\n";
			$rule .= '  || (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "on") !== false))' . "\n";
			$rule .= '  || (isset($_SERVER["HTTP_CF_VISITOR"]) && (strpos($_SERVER["HTTP_CF_VISITOR"], "https") !== false))' . "\n";
			$rule .= '  || (isset($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"], "https") !== false))' . "\n";
			$rule .= '  || (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_X_FORWARDED_PROTO"], "https") !== false))' . "\n";
			$rule .= '  || (isset($_SERVER["HTTP_X_PROTO"]) && (strpos($_SERVER["HTTP_X_PROTO"], "SSL") !== false))' . "\n";
			$rule .= '  ) {' .$break;
			$rule .= '    return true;' .$break;
			$rule .= '  }' .$break;
			$rule .= '    return false;'.$break;
			$rule .= '}'.$break;
			$rule .= 'if ( rsssl_is_ssl() ) '.$this->wrap_header('Strict-Transport-Security', "max-age=$max_age;$subdomains$preload");
		}

		// Do not add the upgrade-insecure-requests header here when CSP is enforced, CSP will include this option when it is enabled
		$rule .= $this->get_csp_rules();

		if ( rsssl_get_option( 'x_xss_protection' ) ) {
			$rule .= $this->wrap_header( 'X-XSS-Protection', "0" );
		}

		if ( rsssl_get_option( 'x_content_type_options' ) ) {
			$rule .= $this->wrap_header( 'X-Content-Type-Options', "nosniff" );
		}

		$referrer_policy = rsssl_get_option( 'referrer_policy' );
		if ( $referrer_policy && $referrer_policy !== 'disabled' ) {
			$rule .= $this->wrap_header( 'Referrer-Policy', $referrer_policy );
		}
		if ( rsssl_get_option( 'enable_permissions_policy' ) ) {
			$rule .= $this->generate_permissions_policy_header( );
		}

		$x_frame_options = rsssl_get_option( 'x_frame_options' );
		if ( $x_frame_options && $x_frame_options !== 'disabled' ) {
			$rule .= $this->wrap_header( 'X-Frame-Options', strtoupper($x_frame_options) );
		}

		$cross_origin_opener_policy = rsssl_get_option('cross_origin_opener_policy');
		if ( !empty($cross_origin_opener_policy) && $cross_origin_opener_policy !== 'disabled' ) {
			$rule .= $this->wrap_header( 'Cross-Origin-Opener-Policy', $cross_origin_opener_policy );
		}
		$cross_origin_resource_policy = rsssl_get_option('cross_origin_resource_policy');
		if ( !empty($cross_origin_resource_policy) && $cross_origin_resource_policy !== 'disabled' ) {
			$rule .= $this->wrap_header( 'Cross-Origin-Resource-Policy', $cross_origin_resource_policy );
		}
		$cross_origin_embedder_policy = rsssl_get_option('cross_origin_embedder_policy');
		if ( !empty($cross_origin_embedder_policy) && $cross_origin_embedder_policy !== 'disabled' ) {
			$rule .= $this->wrap_header( 'Cross-Origin-Embedder-Policy', $cross_origin_embedder_policy );
		}
		//close headers already send if
		$rule .= '}'.$break;
		return $rules."\n".$rule;
	}

	/**
	 * Get permissions policy rules
	 * @return string
	 */

	public function generate_permissions_policy_header(): string {
		$permissions_policy_values = rsssl_get_option('permissions_policy');
		$rules = [];
		if ( !is_array($permissions_policy_values) ) {
			$permissions_policy_values = [];
		}
		foreach ( $permissions_policy_values as $policy ) {
			switch ($policy['value']) {
				case '*':
					$rules[] = $policy['id'] ."=(*)";
					break;
				case 'self':
					$rules[] = $policy['id'] ."=(self)";
					break;
				default:
				case '()':
					$rules[] = $policy['id'] ."=()";
			}
		}
		$php_rule = '';
		if ( !empty( $rules) ) {
			$rules = implode(', ', $rules);
			$php_rule = $this->wrap_header('Permissions-Policy', $rules);
		}

		update_option('rsssl_pro_permissions_policy_headers_for_php', $php_rule);
		return $php_rule;
	}

	/**
	 * Wrap a header in the correct format
	 *
	 * @param string $header
	 * @param string $rules
	 *
	 * @return string
	 */

	public function wrap_header( string $header, string $rules ): string {
		$break = "\n";
		return 'header(' . '"' . $header . ": " . $rules . '"' . ');' . $break;
	}

	/**
	 * Generate CSP rules
	 *
	 * @param string $violateddirective
	 * @param string $uri
	 * @param array  $rules //previously detected rules
	 *
	 * @return array
	 */

	public function generate_csp_rule( string $violateddirective, string $uri, array $rules ): array {
		// Check the violateddirective is valid
		if ( isset($this->directives[$violateddirective]) ){
			// If the violated directive has an existing rule, update it
			if ( isset($rules[$violateddirective]) ) {
				$rule_template = $this->directives[$violateddirective]; //'script-src-elem'   => "script-src-elem 'self' {uri}; ",
				//get existing rule
				$existing_rule = $rules[$violateddirective]; //'script-src-elem'   => "script-src-elem 'self' 'unsafe-inline';";
				//get part of directive before {uri}
				$rule_part = substr($rule_template, 0, strpos($rule_template, '{uri}')); //"script-src-elem 'self' "
				// URI can be both URL or a directive (for example script-src)
				// Check if the current rule already contains the URI
				if (strpos($existing_rule, $uri) !== false) {
					// If it contains the uri, do not add it again. Keep existing rule
					$new_rule = $existing_rule;
				} else {
					//does not contain the uri, add it.
					$new_rule = str_replace($rule_part, $rule_part . $uri . " ", $existing_rule);
				}
				//insert in array
				$rules[$violateddirective] = $new_rule;
			} else {
				$rules[$violateddirective] = str_replace('{uri}', $uri, $this->directives[$violateddirective]);
			}
		}

		return $rules;
	}

	/**
	 * Check if a header check is currently running
	 *
	 * @return bool
	 */
	public function is_header_check_running(): bool {
//		@todo Header detection disabled, enable in future version
		return false;
		$headers = get_option('rsssl_class_headers_headers_check');
		if ( !$headers || !isset($headers['header_check_active']) ){
			return true;
		}

		return $headers['header_check_active'];
	}

	/**
	 * Get recommended security header function
	 * The result is stored in a transient, but this transient is cleared on each pageload when on the settings page.
	 *
	 * @param string $type
	 *
	 * @return mixed
	 *@todo Header detection disabled, enable in future version
	 */
//	public function get_detected_security_headers($type=false)
//	{
//		$nonce = get_site_option("rsssl_header_detection_nonce");
//		//if the settings were changed, we want to recheck the headers
//		if ( !$type ) {
//			delete_option( 'rsssl_class_headers_headers_check' );
//		}
//
//		if ( ! in_array($type, ['used', 'un_used']) ) {
//			$type = 'un_used';
//		}
//		$check_headers = RSSSL_PRO()->admin->security_headers;
//		$headers = get_option('rsssl_class_headers_headers_check');
//		if ( ! $headers ) {
//			//set a default
//			$headers = [
//				'curl_exists' => function_exists( 'curl_init' ),
//				'used' => [],
//				'un_used' => [],
//				'header_check_active' => true,
//			];
//			update_option( 'rsssl_class_headers_headers_check', $headers, false );
//
//			if ( function_exists( 'curl_init' ) ) {
//				$url     = get_site_url();
//				$ch               = curl_init();
//				$detected_headers_with_rsssl = [];
//				curl_setopt( $ch, CURLOPT_URL, $url );
//				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
//				curl_setopt( $ch, CURLOPT_TIMEOUT, 3 ); //timeout in seconds
//				curl_setopt( $ch, CURLOPT_HEADERFUNCTION,
//					function ( $curl, $header ) use ( &$detected_headers_with_rsssl ) {
//						$len    = strlen( $header );
//						$header = explode( ':', $header, 2 );
//						if ( count( $header ) < 2 ) // ignore invalid headers
//						{
//							return $len;
//						}
//						$detected_headers_with_rsssl[] = [
//							'name'  => strtolower( trim( $header[0] ) ),
//							'value' => trim( $header[1] ),
//						];
//
//						return $len;
//					}
//				);
//				curl_exec( $ch );
//				/**
//				 * also do a check without headers set by RSSSL
//				 */
//
//					$url_exclude_rsssl     = get_site_url().'?rsssl_header_test='.$nonce;
//					$ch               = curl_init();
//					$detected_headers_without_rsssl = [];
//					curl_setopt( $ch, CURLOPT_URL, $url_exclude_rsssl );
//					curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
//					curl_setopt( $ch, CURLOPT_TIMEOUT, 3 ); //timeout in seconds
//					curl_setopt( $ch, CURLOPT_HEADERFUNCTION,
//						function ( $curl, $header ) use ( &$detected_headers_without_rsssl ) {
//							$len    = strlen( $header );
//							$header = explode( ':', $header, 2 );
//							if ( count( $header ) < 2 ) // ignore invalid headers
//							{
//								return $len;
//							}
//							$detected_headers_without_rsssl[] = [
//								'name'  => strtolower( trim( $header[0] ) ),
//								'value' => trim( $header[1] ),
//							];
//
//							return $len;
//						}
//					);
//					curl_exec( $ch );
//					error_log("DETECTED HEADERS NO rsssl");
//					error_log(print_r($detected_headers_without_rsssl,true));
//
//
//				// Check if any headers have been found
//				error_log("DETECTED HEADERS with rsssl");
//				error_log(print_r($detected_headers_with_rsssl,true));
//
//				/**
//				 * Get used headers from list of headers. In case of php or advanced headers, we exclude RSSSL headers from this check.
//				 */
//				$detected_headers_for_used_detection = $detected_headers_without_rsssl;
//				if ( ! empty( $detected_headers_for_used_detection ) ) {
//					// Loop through each header and check if it's one of the recommended security headers. If so, add to used_headers array.
//					foreach ( $detected_headers_for_used_detection as $detected_header ) {
//						$name  = $detected_header['name'];
//						$value = $detected_header['value'];
//						if ( ! is_string( $value ) ) {
//							continue;
//						}
//
//						foreach ( $check_headers as $header ) {
//							$name_pattern = $header['pattern']['header'];
//							$value_pattern = $header['pattern']['value'];
//							//the header pattern should always match. If there is a value pattern, it has to match as well.
//							if ( stripos( $name, $name_pattern ) !== false && ( !$value_pattern || stripos( $value, $value_pattern ) !== false) ) {
//								// Remove \n's
//								$value_sanitized                             = str_replace( PHP_EOL, '', $value );
//								$headers['used'][ $header['name'] ]['value'] = $value_sanitized;
//								if ( in_array( $header['name'], $headers['used'] ) ) {
//									$headers['used'][ $header['name'] ]['count'] = 2;
//								} else {
//									$headers['used'][ $header['name'] ]['count'] = 1;
//								}
//							}
//						}
//					}
//				}
//
//				/**
//				 * Get un-used headers from list of ALL headers, otherwise we get "not detected but enabled by RSSSL" notices
//				 */
//				$all_headers = $detected_headers_with_rsssl;
//				if ( ! empty( $all_headers ) ) {
//					$all_used_headers = [];
//					foreach ( $all_headers as $detected_header ) {
//						$name  = $detected_header['name'];
//						$value = $detected_header['value'];
//						if ( ! is_string( $value ) ) {
//							continue;
//						}
//
//						foreach ( $check_headers as $header ) {
//							$name_pattern = $header['pattern']['header'];
//							$value_pattern = $header['pattern']['value'];
//							//the header pattern should always match. If there is a value pattern, it has to match as well.
//							if ( stripos( $name, $name_pattern ) !== false && ( !$value_pattern || stripos( $value, $value_pattern ) !== false) ) {
//								// Remove \n's
//								$value_sanitized = str_replace( PHP_EOL, '', $value );
//								$all_used_headers[ $header['name'] ]['value'] = $value_sanitized;
//								if ( in_array( $header['name'], $all_used_headers ) ) {
//									$all_used_headers[ $header['name'] ]['count'] = 2;
//								} else {
//									$all_used_headers[ $header['name'] ]['count'] = 1;
//								}
//							}
//						}
//					}
//
//					// Now check which headers are unused. Compare the used headers against the $all_used_headers array.
//					foreach ( $check_headers as $header ) {
//						if ( ! array_key_exists( $header['name'], $all_used_headers ) ) {
//							// Do not add CORS headers to unused
//							if ( $header['name'] === 'Cross-Origin-Opener-Policy' || $header['name'] === 'Cross-Origin-Resource-Policy' ) continue;
//
//							// Header is unused, add to unused array
//							$headers['un_used'][] = $header['name'];
//						}
//					}
//				}
//			}
//			$headers['header_check_active'] = false;
//			update_option( 'rsssl_class_headers_headers_check', $headers, false );
//		}
//
//		if ( !$headers['curl_exists'] ) {
//			$headers = [
//				'curl_exists' => false,
//				'used' => [],
//				'un_used' => [],
//				'header_check_active' => true,
//			];
//			if (RSSSL()->server->uses_htaccess() && file_exists(RSSSL()->admin->htaccess_file())) {
//				$htaccess = file_get_contents(RSSSL()->admin->htaccess_file());
//				foreach ($check_headers as $check_header){
//					if ( !preg_match("/".$check_header['pattern']."/", $htaccess, $check) ) {
//						$headers['un_used'][] = $check_header['name'];
//					} else {
//						$headers['used'][] = $check_header['name'];
//					}
//				}
//				$headers['header_check_active'] = false;
//				update_option( 'rsssl_class_headers_headers_check', $headers, false );
//			}
//		}
//		error_log("TOTAL DETECTED LIST ");
//		error_log(print_r($headers, true));
//		$headers = wp_parse_args( $headers, ['curl_exists'=>true, 'un_used'=>[], 'used'=>[] ]);		return $headers[$type];
//	}
}