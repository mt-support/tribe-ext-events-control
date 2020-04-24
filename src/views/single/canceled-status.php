<?php
namespace Tribe\Extensions\EventsControl;

/**
 * Status for a Canceled Event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/single/canceled-status.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTICLE_LINK_HERE}
 *
 * @version TBD
 *
 * @var WP_Post $event  The event post object with properties added by the `tribe_get_event` function.
 * @var string  $status The event status.
 *
 * @see tribe_get_event() For the format of the event object.
 */
use Tribe__Date_Utils as Dates;
use WP_Post;

// Don't print anything when status for this event is not
if ( 'canceled' !== $status ) {
	return;
}

$canceled_reason = get_post_meta( $event->ID, Event_Meta::$key_status_canceled_reason, true );

if ( $canceled_reason ) {
	$label = _x( 'Canceled', 'Text to display canceled on event single if there is a canceled reason.', 'tribe-ext-events-control' );
} else {
	$label = sprintf( _x( 'This %s has been canceled', 'Text to display canceled on event single if no canceled reason.', 'tribe-ext-events-control' ), tribe_get_event_label_singular() );
}

$label = apply_filters( 'tribe_ext_events_control_event_single_canceled_label', $label, $event->ID, $event );

?>
<div class="tribe-ext-events-control-single-notice tribe-ext-events-control-single-notice--canceled">
	<div class="tribe-ext-events-control-text">

		<div class="tribe-ext-events-control-single-notice-header tribe-ext-events-control-text--red tribe-ext-events-control-text--bold tribe-ext-events-control-text--alert-icon">
			<?php echo esc_html( $label ); ?>
		</div>

		<?php if ( $canceled_reason ) : ?>
			<p class="tribe-ext-events-control-single-notice-description">
				<?php echo wp_kses_post( $canceled_reason ); ?>
			</p>
		<?php endif; ?>
	</div>
</div>
