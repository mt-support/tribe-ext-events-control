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
	 * File name to regex map.
	 *
	 * @since TBD
	 *
	 * @var array
	 */
	protected $file_to_regex_map = [
		// Month View
		'month/calendar-body/day/calendar-events/calendar-event/date'         => '/(<div class="tribe-events-calendar-month__calendar-event-datetime">)/',
		'month/calendar-body/day/calendar-events/calendar-event/tooltip/date' => '/(<div class="tribe-events-calendar-month__calendar-event-tooltip-datetime">)/',
		'month/calendar-body/day/multiday-events/multiday-event'              => '/(<div class="tribe-events-calendar-month__multiday-event-bar-inner">)/',
		'month/mobile-events/mobile-day/mobile-event/date'                    => '/(<div class="tribe-events-calendar-month-mobile-events__mobile-event-datetime tribe-common-b2">)/',
		// Week View
		'week/grid-body/events-day/event/date'                                => '/(<div class="tribe-events-pro-week-grid__event-datetime">)/',
		'week/grid-body/events-day/event/tooltip/date'                        => '/(<div class="tribe-events-pro-week-grid__event-tooltip-datetime">)/',
		'week/grid-body/multiday-events-day/multiday-event'                   => '/(<div class="tribe-events-pro-week-grid__multiday-event-bar-inner">)/',
	];

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

		return $notices_html . $template->template( 'single/post-statuses', $args, false );
	}

	/**
	 * Required inclusions for the markers.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $file      Complete path to include the PHP File.
	 * @param array    $name      Template name.
	 * @param Template $template  Current instance of the Template.
	 *
	 * @return void  Template render has no return/
	 */
	public function add_archive_control_markers( $file, $name, $template ) {
		$args = [
			'event' => tribe_get_event( get_the_ID() ),
		];

		$template->template( 'post-statuses', $args );
	}

	/**
	 * Required inclusions for the online link.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $file      Complete path to include the PHP File.
	 * @param array    $name      Template name.
	 * @param Template $template  Current instance of the Template.
	 *
	 * @return void  Template render has no return/
	 */
	public function add_archive_online_link( $file, $name, $template ) {
		$template->template( 'online-link' );
	}

	/**
	 * Adds Template for Online Event.
	 *
	 * @since TBD
	 *
	 * @param string   $file      Complete path to include the PHP File.
	 * @param array    $name      Template name.
	 * @param Template $template  Current instance of the Template.
	 *
	 * @return void  Template render has no return/
	 */
	public function add_online_event( $file, $name, $template ) {
		$template->template( 'online-event' );
	}

	/**
	 * Inserts HTML after regex match.
	 *
	 * @since TBD
	 *
	 * @param string   $template_name Template name to insert into the html.
	 * @param string   $html          HTML to be modified.
	 * @param string   $file          Complete path to include the PHP File.
	 * @param array    $name          Template name.
	 * @param Template $template      Current instance of the Template.
	 *
	 * @return void
	 */
	public function regex_insert_template( $template_name, $html, $file, $name, $template ) {
		$filename = implode( '/', $name );

		if ( ! array_key_exists( $filename, $this->file_to_regex_map ) ) {
			return $html;
		}

		$regex       = $this->file_to_regex_map[ $filename ];
		$replacement = '$1' . $template->template( $template_name, [], false );

		return preg_replace( $regex, $replacement, $html );
	}
}
