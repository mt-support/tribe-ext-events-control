<?php
namespace Tribe\Extensions\EventsControl;

/**
 * Class Event_Meta
 *
 * @since   1.0.0
 *
 * @package Tribe\Extensions\EventsControl
 */
class Event_Meta {
	/**
	 * Meta Key for Status field.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $key_status = '_tribe_events_control_status';

	/**
	 * Meta Key for Canceled reason field.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $key_status_canceled_reason = '_tribe_events_control_status_canceled_reason';

	/**
	 * Meta Key for Postponed reason field.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $key_status_postponed_reason = '_tribe_events_control_status_postponed_reason';

	/**
	 * Meta Key for Online field.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $key_online = '_tribe_events_control_online';

	/**
	 * Meta Key for Online URL field.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $key_online_url = '_tribe_events_control_online_url';
}