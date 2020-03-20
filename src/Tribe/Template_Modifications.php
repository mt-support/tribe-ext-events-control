<?php
namespace Tribe\Extensions\EventsControl;

use Tribe__Template as Template;

/**
 * Class Template_Modifications
 *
 * @since   1.0.0
 *
 * @package Tribe\Extensions\EventsControl
 */
class Template_Modifications {

	/**
	 * Required inclusions for the markers.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $file      Complete path to include the PHP File.
	 * @param string   $name      Template name.
	 * @param Template $template  Current instance of the Template.
	 *
	 */
	public function add_archive_control_status( $file, $name, $template ) {
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
	 */
	public function add_archive_online_link( $file, $name, $template ) {
		$template->template( 'online-link' );
	}
}