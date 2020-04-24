<?php
namespace Tribe\Extensions\EventsControl;

/**
 * Status for a Postponed Event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/single/postponed-status.php
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
use Tribe__Date_Utils as Dates;
use WP_Post;

// Don't print anything when status for this event is not
if ( 'postponed' !== $status ) {
	return;
}

$postponed_reason = get_post_meta( $event->ID, Event_Meta::$key_status_postponed_reason, true );

if ( $postponed_reason ) {
	$label = _x( 'Postponed', 'Text to display postponed on event single if there is a postponed reason.', 'tribe-ext-events-control' );
} else {
	$label = sprintf( _x( 'This %s has been postponed', 'Text to display postponed on event single if no postponed reason.', 'tribe-ext-events-control' ), tribe_get_event_label_singular() );
}

$label = apply_filters( 'tribe_ext_events_control_event_single_postponed_label', $label, $event->ID, $event );

?>
<div class="tribe-ext-events-control-single-notice tribe-ext-events-control-single-notice--postponed">
	<div class="tribe-ext-events-control-text">

		<div class="tribe-ext-events-control-single-notice-header tribe-ext-events-control-text--red tribe-ext-events-control-text--bold tribe-ext-events-control-text--alert-icon">
			<?php echo esc_html( $label ); ?>
		</div>

		<?php if ( $postponed_reason ) : ?>
			<p class="tribe-ext-events-control-single-notice-description">
				<?php echo wp_kses_post( $postponed_reason ); ?>
			</p>
		<?php endif; ?>
	</div>
</div>
