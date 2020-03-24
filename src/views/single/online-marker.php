<?php
namespace Tribe\Extensions\EventsControl;

/**
 * Marker for an online event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/single/online-marker.php
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
use Tribe__Date_Utils as Dates;
use WP_Post;

$online       = tribe_is_truthy( get_post_meta( $event->ID, Event_Meta::$key_online, true ) );
$online_url   = get_post_meta( $event->ID, Event_Meta::$key_online_url, true );
$online_label = apply_filters( 'tribe_ext_events_control_online_label', _x( 'Livestream', 'Online label on single view', 'tribe-ext-events-control' ), $event->ID, $event );
$watch_label  = apply_filters( 'tribe_ext_events_control_watch_label', _x( 'Watch Now', 'Label for an online event link', 'tribe-ext-events-control' ), $event->ID, $event );

// Don't print anything when status for this event is not
if ( ! $online ) {
	return;
}

?>
<div class="tribe-ext-events-control-single-notice tribe-ext-events-control-single-notice--live">
	<div class="tribe-ext-events-control-text">
		<span class="tribe-ext-events-control-text--blue tribe-ext-events-control-text--bold tribe-ext-events-control-text--live-icon">
			<?php echo esc_html( $online_label ); ?>

			<?php if ( $online_url ) : ?>
				<span class="tribe-ext-events-control-text--bold tribe-ext-events-control-single-notice-live-link">
					<a href="<?php echo esc_url( $online_url ) ?>" target="_blank">
						<?php echo esc_html( $watch_label ); ?>
					</a>
				</span>
			<?php endif; ?>
		</span>
	</div>
</div>
