<?php
namespace Tribe\Extensions\EventsControl;

use WP_Post;

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

	/**
	 * Retrieves an event's status.
	 *
	 * @since 1.1.0
	 *
	 * @param WP_Post $event Event post object.
	 *
	 * @return null|string The event's status.
	 */
	public function get_status( $event ) {
		if ( ! $event instanceof WP_Post ) {
			$event = tribe_get_event( $event );
		}

		if ( ! $event ) {
			return null;
		}

		return get_post_meta( $event->ID, static::$key_status, true );
	}

	/**
	 * Retrieves an event's cancellation reason.
	 *
	 * @since 1.1.0
	 *
	 * @param WP_Post $event Event ID.
	 *
	 * @return null|string The event's cancellation reason.
	 */
	public function get_canceled_reason( $event ) {
		if ( ! $event instanceof WP_Post ) {
			$event = tribe_get_event( $event );
		}

		if ( ! $event ) {
			return null;
		}

		return get_post_meta( $event->ID, static::$key_status_canceled_reason, true );
	}

	/**
	 * Retrieves an event's postponed reason.
	 *
	 * @since 1.1.0
	 *
	 * @param WP_Post $event Event post object.
	 *
	 * @return null|string The event's postponed reason.
	 */
	public function get_postponed_reason( $event ) {
		if ( ! $event instanceof WP_Post ) {
			$event = tribe_get_event( $event );
		}

		if ( ! $event ) {
			return null;
		}

		return get_post_meta( $event->ID, static::$key_status_postponed_reason, true );
	}

	/**
	 * Retrieves an event's online URL.
	 *
	 * @since 1.1.0
	 *
	 * @param WP_Post $event Event post object.
	 *
	 * @return null|string The event's online URL.
	 */
	public function get_online_url( $event ) {
		if ( ! $event instanceof WP_Post ) {
			$event = tribe_get_event( $event );
		}

		if ( ! $event ) {
			return null;
		}

		return get_post_meta( $event->ID, static::$key_online_url, true );
	}

	/**
	 * Retrieves whether the event is marked as online or not.
	 *
	 * @since 1.1.0
	 *
	 * @param WP_Post $event Event post object.
	 *
	 * @return bool Whether the event is online or not.
	 */
	public function is_online( $event ) {
		if ( ! $event instanceof WP_Post ) {
			$event = tribe_get_event( $event );
		}

		if ( ! $event ) {
			return null;
		}

		return tribe_is_truthy( get_post_meta( $event->ID, static::$key_online, true ) );
	}

	/**
	 * Retrieves event control meta.
	 *
	 * @since 1.1.0
	 *
	 * @param WP_Post $event Event post object.
	 *
	 * @return mixed|void
	 */
	public function get_meta( $event ) {
		$data       = [];
		$status     = $this->get_status( $event );
		$reason     = null;
		$is_online  = $this->is_online( $event );
		$online_url = null;

		if ( ! empty( $status ) || ! empty( $is_online ) ) {
			if ( $is_online ) {
				$online_url = $this->get_online_url( $event );
			}

			if ( 'canceled' === $status ) {
				$reason = $this->get_canceled_reason( $event );
			}

			if ( 'postponed' === $status ) {
				$reason = $this->get_postponed_reason( $event );
			}

			$data = [
				'event_status'        => $status,
				'event_status_reason' => $reason,
				'is_online'           => (bool) $is_online,
				'online_url'          => $online_url,
			];
		}

		/**
		 * Filters the events control meta returned by this method.
		 *
		 * @since 1.1.0
		 *
		 * @param array $data Meta data.
		 * @param WP_Post $event Event post object.
		 */
		return apply_filters( 'tribe_ext_events_control_meta_data', $data, $event );
	}
}
