<?php
/**
 * The main service provider for Events Happening Now support
 *
 * @since   1.0.0
 * @package Tribe\Extensions\EventsHappeningNow
 */

namespace Tribe\Extensions\EventsControl;

/**
 * Class Service_Provider
 * @since   1.0.0
 * @package Tribe\Extensions\EventsHappeningNow
 */
class Service_Provider extends \tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		if ( ! tribe_events_views_v2_is_enabled() ) {
			return;
		}

		$this->container->singleton( Metabox::class, Metabox::class, [ 'set_template' ] );
		$this->container->singleton( JSON_LD::class, JSON_LD::class );
		$this->container->singleton( Template_Modifications::class, Template_Modifications::class, [ 'set_template' ] );

		$this->register_hooks();
		$this->register_assets();

		// Register the SP on the container
		$this->container->singleton( 'events-control.provider', $this );
		$this->container->singleton( static::class, $this );
	}

	/**
	 * Registers the provider handling assets
	 *
	 * @since 1.0.0
	 */
	protected function register_assets() {
		$assets = new Assets( $this->container );
		$assets->register();

		$this->container->singleton( Assets::class, $assets );
	}

	/**
	 * Registers the provider handling all the 1st level filters and actions for the extension
	 *
	 * @since 1.0.0
	 */
	protected function register_hooks() {
		$hooks = new Hooks( $this->container );
		$hooks->register();

		// Allow Hooks to be removed, by having the them registered to the container.
		$this->container->singleton( Hooks::class, $hooks );
		$this->container->singleton( 'events-control.views.hooks', $hooks );
	}
}
