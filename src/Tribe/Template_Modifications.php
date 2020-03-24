<?php
namespace Tribe\Extensions\EventsControl;

use Tribe__Template as Template;
use Tribe__Events__Main as Events_Plugin;
use WP_Post;

/**
 * Class Template_Modifications
 *
 * @since   1.0.0
 *
 * @package Tribe\Extensions\EventsControl
 */
class Template_Modifications {
	/**
	 * Stores the template class used.
	 *
	 * @since 1.0.0
	 *
	 * @var Template
	 */
	protected $template;

	/**
	 * Normally ran when the class is setting up but configures the template instance that we will use render non v2 contents.
	 *
	 * @since 1.0.0
	 *
	 * @return void Setter with no return.
	 */
	public function set_template() {
		$this->template = new Template();
		$this->template->set_template_origin( tribe( Main::class ) );
		$this->template->set_template_folder( 'src/views' );

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
	 * Add the control classes for the views v2 elements
	 *
	 * @since 1.0.0
	 *
	 * @param int|WP_Post      $event      Post ID or post object.
	 *
	 * @return string[]
	 */
	public function get_post_classes( $event ) {
		$classes = [];
		if ( ! tribe_is_event( $event ) ) {
			return $classes;
		}

		$event = tribe_get_event( $event );

		$status = get_post_meta( $event->ID, Event_Meta::$key_status, true );
		if ( $status ) {
			$classes[] = 'tribe-ext-events-control-list-event--' . sanitize_html_class( $status );
		}

		$online =  tribe_is_truthy( get_post_meta( $event->ID, Event_Meta::$key_online, true ) );
		if ( $online ) {
			$classes[] = 'tribe-ext-events-control-list-event--live';
		}

		return $classes;
	}

	/**
	 * Include the control markers to the single page.
	 *
	 * @since 1.0.0
	 *
	 * @param  string  $notices_html  Previously set HTML.
	 * @param  array   $notices       Array of notices added previously.
	 *
	 * @return string  New Before with the control markers appended.
	 */
	public function add_single_control_markers( $notices_html, $notices ) {
		if ( ! is_singular( Events_Plugin::POSTTYPE ) ) {
			return $notices_html;
		}

		$template = $this->get_template();
		$args = [
			'event' => tribe_get_event( get_the_ID() ),
		];

		$notices_html .= $template->template( 'single/canceled-status', $args, false );
		$notices_html .= $template->template( 'single/postponed-status', $args, false );
		$notices_html .= $template->template( 'single/online-marker', $args, false );

		return $notices_html;
	}

	/**
	 * Required inclusions for the markers.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $file      Complete path to include the PHP File.
	 * @param string   $name      Template name.
	 * @param Template $template  Current instance of the Template.
	 *
	 * @return void  Template render has no return/
	 */
	public function add_archive_control_markers( $file, $name, $template ) {
		$template->template( 'online-marker' );
		$template->template( 'canceled-status' );
		$template->template( 'postponed-status' );
	}
	/**
	 * Required inclusions for the online link.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $file      Complete path to include the PHP File.
	 * @param string   $name      Template name.
	 * @param Template $template  Current instance of the Template.
	 *
	 * @return void  Template render has no return/
	 */
	public function add_archive_online_link( $file, $name, $template ) {
		$template->template( 'online-link' );
	}
}
