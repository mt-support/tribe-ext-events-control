<?php
namespace Tribe\Extensions\EventsControl;

use Tribe__Events__Main as Events_Plugin;
use Tribe__Template as Template;
use WP_Post;

/**
 * Class Metabox
 *
 * @since   1.0.0
 *
 * @package Tribe\Extensions\EventsControl
 */
class Metabox {

	/**
	 * ID for the metabox in WP.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $id = 'tribe-events-control';

	/**
	 * Stores the template class used.
	 *
	 * @since 1.0.0
	 *
	 * @var Template
	 */
	protected $template;

	/**
	 * Fetches the Metabox title.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html_x( 'Events Advanced Control', 'Meta box title for the Advanced Control', 'tribe-ext-events-control' );
	}

	/**
	 * Normally ran when the class is setting up but configures the template instance that we will use to render the metabox contents.
	 *
	 * @since 1.0.0
	 *
	 * @return void Setter with no return.
	 */
	public function set_template() {
		$this->template = new Template();
		$this->template->set_template_origin( tribe( Main::class ) );
		$this->template->set_template_folder( 'src/admin-views' );

		// Configures this templating class extract variables.
		$this->template->set_template_context_extract( true );
	}

	/**
	 * Gets the instance of template class set for the metabox.
	 *
	 * @since 1.0.0
	 *
	 * @return Template Instance of the template we are using to render this metabox.
	 */
	public function get_template() {
		return $this->template;
	}

	/**
	 * Render the actual metabox contents.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post Which post we are using here.
	 *
	 * @return false|string
	 */
	public function render( $post ) {
		$args = [
			'post' => $post,
		];

		return $this->get_template()->template( 'metabox/container', $args, true );
	}

	/**
	 * Register the metabox in WP system.
	 *
	 * @since 1.0.0
	 *
	 * @return void Registering has no return.
	 */
	public function register() {
		add_meta_box(
			static::$id,
			$this->get_title(),
			[ $this, 'render' ],
			Events_Plugin::POSTTYPE,
			'side',
			'high'
		);
	}

	/**
	 * Saves the metabox, which will be triggered in `save_post`.
	 *
	 * @since 1.0.0
	 *
	 * @todo Requires impleementation of any saving.
	 *
	 * @return void Just saving requires no return.
	 */
	public function save() {

	}

}