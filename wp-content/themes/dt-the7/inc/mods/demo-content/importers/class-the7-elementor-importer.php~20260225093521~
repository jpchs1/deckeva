<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Importer {

	/**
	 * @var The7_Demo_Content_Tracker
	 */
	private $content_tracker;
	private $importer;

	public function __construct( $importer, $content_tracker ) {
		$this->content_tracker = $content_tracker;
		$this->importer = $importer;
	}

	public function import_options( $options ) {
		$origin_options = [];

		foreach ( $options as $key => $option ) {
			$origin_options[ $key ] = get_option( $key, null );

			if ( isset( $option ) ) {
				update_option( $key, $option );
			} else {
				delete_option( $key );
			}
		}

		$this->content_tracker->add( 'origin_elementor_options', $origin_options );

		if ( class_exists( 'Elementor\Plugin' ) ) {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}

		if ( class_exists( 'ElementorPro\Modules\ThemeBuilder\Module' ) ) {
			\ElementorPro\Modules\ThemeBuilder\Module::instance()->get_conditions_manager()->get_cache()->regenerate();
		}
	}

	/**
	 * @param array $kit_settings
	 */
	public function import_kit_settings( $kit_settings ) {
        $kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
		$kit = \Elementor\Plugin::$instance->documents->get( $kit_id );
		$current_settings = (array) $kit->get_meta( \Elementor\Core\Settings\Page\Manager::META_KEY ) ?: [];

		foreach ( $kit_settings as $key => $setting ) {
			if ( isset( $setting ) ) {
				$current_settings[ $key ] = $setting;
			} else {
				unset( $current_settings[ $key ] );
			}
		}

		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_manager->save_settings( $current_settings, $kit_id );
	}

	public function fix_elementor_data() {
		global $wpdb;

		$ids = $wpdb->get_col("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_elementor_data'");

		foreach ( $ids as $post_id ) {
			$elementor_data = json_decode( get_post_meta( $post_id, '_elementor_data', true ), true );
			static::apply_elementor_data_patch( $elementor_data, [ $this, 'fix_the7_widgets_terms' ] );
			update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $elementor_data ) ) );
		}
	}

	public static function apply_elementor_data_patch( &$elementor_data, $callback ) {
		foreach ( $elementor_data as &$element ) {
			if ( isset( $element['elType'] ) && $element['elType'] === 'widget' ) {
				if ( is_callable( $callback ) ) {
					$element = $callback( $element );
				}
			}

			if ( ! empty( $element['elements'] ) ) {
				static::apply_elementor_data_patch( $element['elements'], $callback );
			}
		}
	}

	protected function fix_the7_widgets_terms( $widget ) {
		if ( isset( $widget['settings']['terms'] ) && is_array( $widget['settings']['terms'] ) ) {
			foreach ( $widget['settings']['terms'] as &$term ) {
				$term = (string) $this->importer->get_processed_term( $term );
			}
		}

		return $widget;
	}
}
