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
 * @version 4.9.9
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */
use Tribe__Date_Utils as Dates;
use WP_Post;

$status           = get_post_meta( $event->ID, Event_Meta::$key_status, true );
$postponed_reason = get_post_meta( $event->ID, Event_Meta::$key_status_postponed_reason, true );

// Don't print anything when status for this event is not
if ( 'postponed' !== $status ) {
	return;
}

?>
<div class="tribe-ext-events-control-single-notice tribe-ext-events-control-single-notice--postponed">
	<div class="tribe-ext-events-control-text">

		<div class="tribe-ext-events-control-single-notice-header tribe-ext-events-control-text--red tribe-ext-events-control-text--bold tribe-ext-events-control-text--alert-icon">
			<?php echo esc_html_x( 'Postponed', 'Text next to the date to display postponed', 'tribe-ext-events-control' ); ?>
		</div>

		<?php if ( $postponed_reason ) : ?>
			<div class="tribe-ext-events-control-single-notice-description">
				<?php echo wp_kses_post( $postponed_reason ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
