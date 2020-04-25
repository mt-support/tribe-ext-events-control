<?php
namespace Tribe\Extensions\EventsControl;

use WP_Post;

/**
 * Class JSON_LD
 *
 * @since   1.0.0
 *
 * @package Tribe\Extensions\EventsControl
 */
class JSON_LD {

	const CANCELED_SCHEMA = 'https://schema.org/EventCancelled';

	const POSTPONED_SCHEMA = 'https://schema.org/EventPostponed';

	const MOVED_ONLINE_SCHEMA = 'https://schema.org/EventMovedOnline';

	const ONLINE_EVENT_ATTENDANCE_MODE = 'https://schema.org/OnlineEventAttendanceMode';

	/**
	 * Modifiers to the JSON LD event object for canceled events.
	 *
	 * @since 1.0.0
	 *
	 * @param object  $data The JSON-LD object.
	 * @param array   $args The arguments used to get data.
	 * @param WP_Post $post The post object.
	 *
	 * @return object JSON LD object after modifications.
	 */
	public function modify_canceled_event( $data, $args, $post ) {
		// Skip any events without proper data.
		if ( empty( $data->startDate ) || empty( $data->endDate ) ) {
			return $data;
		}
		$status = tribe( Event_Meta::class )->get_status( $post->ID );

		// Bail on modifications for non canceled events.
		if ( 'canceled' !== $status ) {
			return $data;
		}
		// Modify the Status Schema
		$data->eventStatus = static::CANCELED_SCHEMA;
		return $data;
	}

	/**
	 * Modifiers to the JSON LD event object for postponed events.
	 *
	 * @since 1.0.0
	 *
	 * @param object  $data The JSON-LD object.
	 * @param array   $args The arguments used to get data.
	 * @param WP_Post $post The post object.
	 *
	 * @return object JSON LD object after modifications.
	 */
	public function modify_postponed_event( $data, $args, $post ) {
		// Skip any events without proper data.
		if ( empty( $data->startDate ) || empty( $data->endDate ) ) {
			return $data;
		}
		$status = tribe( Event_Meta::class )->get_status( $post->ID );

		// Bail on modifications for non canceled events.
		if ( 'postponed' !== $status ) {
			return $data;
		}
		// Modify the Status Schema
		$data->eventStatus = static::POSTPONED_SCHEMA;

		return $data;
	}

	/**
	 * Modifiers to the JSON LD event object for online attendance events.
	 *
	 * @since 1.0.0
	 *
	 * @param object  $data The JSON-LD object.
	 * @param array   $args The arguments used to get data.
	 * @param WP_Post $post The post object.
	 *
	 * @return object JSON LD object after modifications.
	 */
	public function modify_online_event( $data, $args, $post ) {
		// Skip any events without proper data.
		if ( empty( $data->startDate ) || empty( $data->endDate ) ) {
			return $data;
		}

		$online = tribe( Event_Meta::class )->is_online( $post->ID );

		/**
		 * Filters if an Event is Considered Online.
		 *
		 * @since TBD
		 *
		 * @param boolean $online If an event is considered online.
		 * @param object  $data   The JSON-LD object.
		 * @param array   $args   The arguments used to get data.
		 * @param WP_Post $post   The post object.
		 */
		$online = apply_filters( 'tribe_events_single_event_online_status', $online, $data, $args, $post );

		// Bail on modifications for non canceled events.
		if ( ! $online ) {
			return $data;
		}

		// Prevent modifying an already set postponed event to online status.
		if ( empty( $data->eventStatus ) || static::POSTPONED_SCHEMA !== $data->eventStatus ) {
			// Modify the Status Schema
			$data->eventStatus = static::MOVED_ONLINE_SCHEMA;
		}

		// if online, set the attendance mode
		$data->eventAttendanceMode = static::ONLINE_EVENT_ATTENDANCE_MODE;

		$data->location = (object) [
			'@type' => 'VirtualLocation',
			'url'   => esc_url( $this->get_online_url( $post ) ),
		];

		$i = 1;

		return $data;
	}

	/**
	 * Get the Online URL for an Event Trying the Online URL, the Website URL, and using the Permalink if nothing found.
	 * A URL is required when using VirtualLocation.
	 *
	 * @since TBD
	 *
	 * @param WP_Post $post The post object to use to get the online url for an event.
	 *
	 * @return mixed The string of the online url for an event if available.
	 */
	protected function get_online_url( $post ) {

		$online_url = tribe( Event_Meta::class )->get_online_url( $post->ID );

		// If Empty Get Website URL.
		if ( empty( $online_url ) ) {
			$online_url = get_post_meta( $post->ID, '_EventURL', true );
		}

		// If Both are Empty Then Get the Permalink.
		if ( empty( $online_url ) ) {
			$online_url = get_the_permalink( $post->ID );
		}

		return $online_url;
	}

}