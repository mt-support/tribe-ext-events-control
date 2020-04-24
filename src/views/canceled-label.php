<?php

namespace Tribe\Extensions\EventsControl;

/**
 * Marker for a canceled event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/canceled-label.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTICLE_LINK_HERE}
 *
 * @version TBD
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */
use WP_Post;

$status = get_post_meta( $event->ID, Event_Meta::$key_status, true );
$label  = apply_filters( 'tribe_ext_events_control_canceled_label', _x( 'Canceled', 'Canceled label', 'tribe-ext-events-control' ), $event->ID, $event );

if ( 'canceled' !== $status ) {
	return;
}

?>
<span class="tribe-ext-events-control-status-label tribe-ext-events-control-status-label--canceled">
	<?php echo esc_html( $label ); ?>
</span>
