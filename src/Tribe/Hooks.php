<?php
/**
 * Handles hooking all the actions and filters used by the module.
 *
 * To remove a filter:
 * remove_filter( 'some_filter', [ tribe( Tribe\Extensions\EventsHappeningNow\Hooks::class ), 'some_filtering_method' ] );
 * remove_filter( 'some_filter', [ tribe( 'events-happening-now.views.filters' ), 'some_filtering_method' ] );
 *
 * To remove an action:
 * remove_action( 'some_action', [ tribe( Tribe\Extensions\EventsHappeningNow\Hooks::class ), 'some_method' ] );
 * remove_action( 'some_action', [ tribe( 'events-happening-now.views.hooks' ), 'some_method' ] );
 *
 * @since 1.0.0
 *
 * @package Tribe\Extensions\EventsHappeningNow
 */

namespace Tribe\Extensions\EventsControl;
use Tribe__Template;
use WP_Post;

/**
 * Class Hooks
 *
 * @since 1.0.0
 *
 * @package Tribe\Extensions\EventsHappeningNow
 */
class Hooks extends \tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->add_actions();
		$this->add_filters();
	}

	/**
	 * Adds the actions required by the extension.
	 *
	 * @since 1.0.0
	 */
	protected function add_actions() {
		add_action( 'add_meta_boxes', [ $this, 'action_add_metabox' ] );
		add_action( 'init', [ $this, 'action_register_metabox_fields' ] );
		add_action( 'save_post', [ $this, 'action_save_metabox' ], 15, 3 );

		add_action( 'tribe_template_before_include:events/list/event/date/meta', [ $this, 'action_add_archive_control_status' ], 15, 3 );
		add_action( 'tribe_template_after_include:events/list/event/description', [ $this, 'action_add_archive_online_link' ], 15, 3 );
	}

	/**
	 * Adds the actions required by the extension.
	 *
	 * @since 1.0.0
	 */
	protected function add_filters() {
		add_filter( 'tribe_template_origin_namespace_map', [ $this, 'filter_add_template_origin_namespace' ], 15, 3 );
		add_filter( 'tribe_template_path_list', [ $this, 'filter_template_path_list' ], 15, 2 );
	}

	/**
	 * Includes Pro into the path namespace mapping, allowing for a better namespacing when loading files.
	 *
	 * @since 1.0.0
	 *
	 * @param array            $namespace_map Indexed array containing the namespace as the key and path to `strpos`.
	 * @param string           $path          Path we will do the `strpos` to validate a given namespace.
	 * @param Tribe__Template  $template      Current instance of the template class.
	 *
	 * @return array  Namespace map after adding Pro to the list.
	 */
	public function filter_add_template_origin_namespace( $namespace_map, $path, Tribe__Template $template ) {
		$namespace_map[ Main::SLUG ] = Main::PATH;
		return $namespace_map;
	}

	/**
	 * Filters the list of folders TEC will look up to find templates to add the ones defined by PRO.
	 *
	 * @since 1.0.0
	 *
	 * @param array           $folders  The current list of folders that will be searched template files.
	 * @param Tribe__Template $template Which template instance we are dealing with.
	 *
	 * @return array The filtered list of folders that will be searched for the templates.
	 */
	public function filter_template_path_list( array $folders, Tribe__Template $template ) {
		$path = (array) rtrim( Main::PATH, '/' );

		// Pick up if the folder needs to be added to the public template path.
		$folder = [ 'src/views' ];

		if ( ! empty( $folder ) ) {
			$path = array_merge( $path, $folder );
		}

		$folders[ Main::SLUG ] = [
			'id'        => Main::SLUG,
			'namespace' => Main::SLUG,
			'priority'  => 10,
			'path'      => implode( DIRECTORY_SEPARATOR, $path ),
		];

		return $folders;
	}

	/**
	 * Register the metabox in the correct action.
	 *
	 * @since 1.0.0
	 *
	 * @return void Action hook with no return.
	 */
	public function action_add_metabox() {
		$this->container->make( Metabox::class )->register();
	}

	/**
	 * Register the metabox fields in the correct action.
	 *
	 * @since 1.0.0
	 *
	 * @return void Action hook with no return.
	 */
	public function action_register_metabox_fields() {
		$this->container->make( Metabox::class )->register_fields();
	}

	/**
	 * Register the metabox fields in the correct action.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $post_id Which post ID we are dealing with when saving.
	 * @param WP_Post $post    WP Post instance we are saving.
	 * @param boolean $update  If we are updating the post or not.
	 *
	 * @return void Action hook with no return.
	 */
	public function action_save_metabox( $post_id, $post, $update ) {
		$this->container->make( Metabox::class )->save( $post_id, $post, $update );
	}

	public function action_add_archive_control_status( $file, $name, $template ) {
		$this->container->make( Template_Modifications::class )->add_archive_control_status( $file, $name, $template );
	}
	public function action_add_archive_online_link( $file, $name, $template ) {
		$this->container->make( Template_Modifications::class )->add_archive_online_link( $file, $name, $template );
	}
}
