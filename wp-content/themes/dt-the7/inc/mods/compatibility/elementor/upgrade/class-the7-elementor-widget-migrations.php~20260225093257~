<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor\Upgrade;

defined( 'ABSPATH' ) || exit;

abstract class The7_Elementor_Widget_Migrations {

	public static function get_widget_name() {
		return '';
	}

	public static function run( $migration, $updater = null ) {
		if ( $updater === null ) {
			$updater = new \The7\Adapters\Elementor\Upgrade\The7_Elementor_Updater();
		}

		$changes = [
			[
				'callback'    => [ static::class, $migration ],
				'control_ids' => [],
			],
		];
		\Elementor\Core\Upgrade\Upgrade_Utils::_update_widget_settings( static::get_widget_name(), $updater, $changes );
	}

	/**
	 * @param array $element
	 *
	 * @return bool
	 */
	protected static function is_the_right_widget( $element ) {
		return ! empty( $element['widgetType'] ) && $element['widgetType'] === static::get_widget_name();
	}

}
