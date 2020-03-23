<?php
namespace Tribe\Extensions\EventsControl;

/**
 * Link for an online event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-control/single/online-link.php
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
use WP_Post;

$online = tribe_is_truthy( get_post_meta( $event->ID, Event_Meta::$key_online, true ) );
$online_url = get_post_meta( $event->ID, Event_Meta::$key_online_url, true );

// Dont print anything when status for this event is not
if ( ! $online || ! $online_url ) {
	return;
}

?>
<div class="tribe-common-b2">
	<a href="<?php echo esc_url( $online_url ) ?>" target="_blank">
		<?php echo esc_html_x( 'Watch Now', 'Label for a livestream link', 'tribe-ext-events-control' ); ?>
	</a>
</div>