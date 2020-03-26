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
		$online     = tribe( Event_Meta::class )->is_online( $post->ID );
		$online_url = tribe( Event_Meta::class )->get_online_url( $post->ID );

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
		$data->eventAttendenceMode = static::ONLINE_EVENT_ATTENDANCE_MODE;

		if ( $online_url ) {
			$data->location = (object) [
				'@type' => 'VirtualLocation',
				'url'   => esc_url( $online_url ),
			];
		}


		$i=1;
		return $data;
	}
}
