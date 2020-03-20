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
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @version 4.9.9
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */
use Tribe__Date_Utils as Dates;
use WP_Post;

$online = tribe_is_truthy( get_post_meta( $event->ID, Metabox::$meta_online, true ) );
$online_url = get_post_meta( $event->ID, Metabox::$meta_online_url, true );

// Dont print anything when status for this event is not
if ( ! $online ) {
	return;
}

?>
<div class="tribe-common-b2">
	<?php echo esc_html_x( 'Livestream', 'Livestream label on single view', 'tribe-ext-events-control' ); ?>

    <?php if ( $online_url ) : ?>
	<a href="<?php echo esc_url( $online_url ) ?>" target="_blank">
		<?php echo esc_html_x( 'Watch Now', 'Label for a livestream link', 'tribe-ext-events-control' ); ?>
	</a>
    <?php endif; ?>
</div>
