<?php
/**
 * @package Polylang
 */

namespace WP_Syntex\Polylang\Options\Business;

use WP_Syntex\Polylang\Options\Abstract_Option;
use WP_Syntex\Polylang\Model\Languages;


defined( 'ABSPATH' ) || exit;

/**
 * Class defining navigation menus array option.
 *
 * @since 3.7
 */
class Nav_Menus extends Abstract_Option {
	/**
	 * Returns option key.
	 *
	 * @since 3.7
	 *
	 * @return string
	 *
	 * @phpstan-return 'nav_menus'
	 */
	public static function key(): string {
		return 'nav_menus';
	}

	/**
	 * Returns the default value.
	 *
	 * @since 3.7
	 *
	 * @return array
	 */
	protected function get_default() {
		return array();
	}

	/**
	 * Returns the JSON schema part specific to this option.
	 *
	 * @since 3.7
	 *
	 * @return array Partial schema.
	 */
	protected function get_data_structure(): array {
		return array(
			'type'                 => 'object', // Correspond to associative array in PHP, @see{https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/#primitive-types}.
			'patternProperties'    => array(
				'[^\/:<>\*\?"\|]+' => array( // Excludes invalid directory name characters @see https://developer.wordpress.org/reference/classes/wp_rest_themes_controller/register_routes/
					'type'                 => 'object',
					'patternProperties'    => array(
						'[\w-]+' => array( // Accepted characters for menu locations @see https://developer.wordpress.org/reference/classes/wp_rest_menu_locations_controller/register_routes/
							'type'              => 'object',
							'patternProperties' => array(
								Languages::SLUG_PATTERN => array( // Language slug as key.
									'type'    => 'integer',
									'minimum' => 0, // A post ID.
								),
							),
							'additionalProperties' => false,
						),
					),
					'additionalProperties' => false,
				),
			),
			'additionalProperties' => false,
		);
	}

	/**
	 * Returns the description used in the JSON schema.
	 *
	 * @since 3.7
	 *
	 * @return string
	 */
	protected function get_description(): string {
		return __( 'Translated navigation menus for each theme.', 'polylang' );
	}
}
