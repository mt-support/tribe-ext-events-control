<?php
namespace Tribe\Extensions\EventsControl;

/**
 * Marker for an online event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/online-marker.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTICLE_LINK_HERE}
 *
 * @version 4.9.9
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */
use WP_Post;

$online       = tribe_is_truthy( get_post_meta( $event->ID, Event_Meta::$key_online, true ) );
$online_label = apply_filters( 'tribe_ext_events_control_online_label', _x( 'Livestream', 'Online label on list view', 'tribe-ext-events-control' ), $event->ID, $event );

// Don't print anything when status for this event is not
if ( ! $online ) {
	return;
}

?>
<div class="tribe-ext-events-control-list-status">
	<span class="tribe-common-b2 tribe-ext-events-control-text tribe-ext-events-control-text--blue tribe-ext-events-control-text--bold tribe-ext-events-control-text--live-icon">
		<?php echo esc_html( $online_label ); ?>
	</span>
</div>
