<?php
/**
* Link for an online event.
*
* Override this template in your own theme by creating a file at:
* [your-theme]/tribe/events-control/post-statuses.php
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

// Dont print anything when there are no statuses for this event.
if ( ! $event ) {
	return;
}

?>
<div class="tribe-common-b2 tribe-ext-events-control-status-archive-container">
	<?php $this->template( 'canceled-status' ); ?>
	<?php $this->template( 'postponed-status' ); ?>
</div>
