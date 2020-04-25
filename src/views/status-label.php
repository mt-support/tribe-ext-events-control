<?php

namespace Tribe\Extensions\EventsControl;

/**
 * Status label for event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/status-label.php
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

if ( ! in_array( $status, [ 'canceled', 'postponed' ] ) ) {
	return;
}

?>
<span class="tribe-ext-events-control-status-label-wrapper">
	<?php $this->template( 'canceled-label', [ 'event' => $event, 'status' => $status ] ); ?>
	<?php $this->template( 'postponed-label', [ 'event' => $event, 'status' => $status ] ); ?>
</span>
