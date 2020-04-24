<?php

namespace Tribe\Extensions\EventsControl;

/**
 * Marker for an online event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/online-event.php
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

$online       = tribe_is_truthy( get_post_meta( $event->ID, Event_Meta::$key_online, true ) );
$online_label = apply_filters( 'tribe_ext_events_control_online_label', _x( 'Online Event', 'Online label on list view', 'tribe-ext-events-control' ), $event->ID, $event );

// Don't print anything when status for this event is not
if ( ! $online ) {
	return;
}

?>
<div class="tribe-common-b2 tribe-common-b2--bold tribe-ext-events-control-online-event">
	<em
		class="tribe-ext-events-control-online-event__icon tribe-ext-events-control-icon tribe-ext-events-control-icon--live"
		aria-label="<?php echo esc_attr( $online_label ); ?>"
		title="<?php echo esc_attr( $online_label ); ?>"
	>
	</em>
	<span class="tribe-ext-events-control-online-event__text">
		<?php echo esc_html( $online_label ); ?>
	</span>
</div>
