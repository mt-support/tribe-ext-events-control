<?php
/**
 * Handles registering all Assets for the Events Happening Now
 *
 * To remove a Assets:
 * tribe( 'assets' )->remove( 'asset-name' );
 *
 * @since 1.0.0
 *
 * @package Tribe\Extensions\EventsHappeningNow
 */
namespace Tribe\Extensions\EventsControl;

use Tribe__Events__Templates;

/**
 * Register
 *
 * @since 1.0.0
 *
 * @package Tribe\Extensions\EventsHappeningNow
 */
class Assets extends \tad_DI52_ServiceProvider {

	/**
	 * Key for this group of assets.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $group_key = 'happening-now';

	/**
	 * Binds and sets up implementations.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$plugin = tribe( Main::class );

		tribe_asset(
			$plugin,
			'tribe-ext-events-happening-now',
			'style.css',
			[
				'tribe-common-full-style',
				'tribe-events-views-v2-skeleton',
			],
			null,
			[
				'groups' => [ static::$group_key ],
			]
		);

		$overrides_stylesheet = Tribe__Events__Templates::locate_stylesheet( 'tribe-events/tribe-ext-events-happening-now.css' );

		if ( ! empty( $overrides_stylesheet ) ) {
			tribe_asset(
				$plugin,
				'tribe-ext-events-happening-now-override',
				$overrides_stylesheet,
				[
					'tribe-common-full-style',
					'tribe-events-views-v2-skeleton',
				],
				null,
				[
					'groups' => [ static::$group_key ],
				]
			);
		}
	}
}
