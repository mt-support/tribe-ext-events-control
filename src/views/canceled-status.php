<?php
namespace Tribe\Extensions\EventsControl;

/**
 * Status for a Canceled Event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/canceled-status.php
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

$status = get_post_meta( $event->ID, Metabox::$meta_status, true );

// Don't print anything when status for this event is not.
if ( 'canceled' !== $status ) {
	return;
}

?>
<div class="tribe-ext-events-control-list-status tribe-ext-events-control-list-status--canceled">
	<span class="tribe-common-b2 tribe-ext-events-control-list__red-text">
		<?php echo esc_html_x( 'Canceled', 'Text next to the date to display canceled', 'tribe-ext-events-control' ); ?>
	</span>
</div>