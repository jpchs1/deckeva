<?php
if ( ! class_exists( 'NjtCF7MLSI18n' ) ) {
	class NjtCF7MLSI18n {

		public function __construct() {
			$this->doHooks();
		}

		private function doHooks() {
			add_action( 'plugins_loaded', array( $this, 'cf7mlsLoadTextdomain' ) );
		}
		public function cf7mlsLoadTextdomain() {
			if ( function_exists( 'determine_locale' ) ) {
				$locale = determine_locale();
			} else {
				$locale = is_admin() ? get_user_locale() : get_locale();
			}
			unload_textdomain( 'cf7-multi-step' );
			load_textdomain( 'cf7-multi-step', CF7MLS_PLUGIN_DIR . '/languages/' . $locale . '.mo' );
			load_plugin_textdomain( 'cf7-multi-step', false, CF7MLS_PLUGIN_DIR . '/languages/' );
		}
	}
	new NjtCF7MLSI18n();
}
