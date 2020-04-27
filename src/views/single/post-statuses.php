<?php
namespace Tribe\Extensions\EventsControl;

/**
 * Link for an online event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/single/post-statuses.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @version 1.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 * @var string $post_statuses The statuses to output.
 *
 * @see tribe_get_event() For the format of the event object.
 */
use WP_Post;

$status = get_post_meta( $event->ID, Event_Meta::$key_status, true );

if ( ! in_array( $status, [ 'canceled', 'postponed' ] ) ) {
	return;
}

?>
<div class="tribe-common-b2 tribe-ext-events-control-status-single-container">
	<?php $this->template( 'single/canceled-status', [ 'event' => $event, 'status' => $status ] ); ?>
	<?php $this->template( 'single/postponed-status', [ 'event' => $event, 'status' => $status ] ); ?>
	<?php // $this->template( 'single/online-marker' ); ?>
</div>
