<?php
namespace  Tribe\Extensions\EventsControl;

use WP_Post;
use Tribe__Template as Template;

/**
 * @var Template $this     Template instance we are using.
 * @var WP_Post  $post     Post we are dealing with.
 * @var Metabox  $metabox  The metabox instance.
 */
?>
<div class="tribe-events-control-metabox-container">
	<?php wp_nonce_field( $metabox::$nonce_action, "{$metabox::$id}[nonce]" ); ?>
	<p>
		<label for="<?php echo esc_attr( "{$metabox::$id}-status-postponed" ); ?>">
			<input
				id="<?php echo esc_attr( "{$metabox::$id}-status-postponed" ); ?>"
				name="<?php echo esc_attr( "{$metabox::$id}[status]" ); ?>"
				type="checkbox"
				value="postponed"
			>
			<?php echo esc_html_x( 'Mark event as Postponed', 'Event State of being postponed in the select field', 'tribe-ext-events-control' ); ?>
		</label>
	</p>
	<div>

	</div>
	<p>
		<label for="<?php echo esc_attr( "{$metabox::$id}-status-canceled" ); ?>">
			<input
				id="<?php echo esc_attr( "{$metabox::$id}-status-canceled" ); ?>"
				name="<?php echo esc_attr( "{$metabox::$id}[status]" ); ?>"
				type="checkbox"
				value="canceled"
			>
			<?php echo esc_html_x( 'Mark event as Canceled', 'Event State of being canceled in the select field', 'tribe-ext-events-control' ); ?>
		</label>
	</p>
	<div>

	</div>
	<p>
		<label for="<?php echo esc_attr( "{$metabox::$id}-online" ); ?>">
			<input
				id="<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
				name="<?php echo esc_attr( "{$metabox::$id}[online]" ); ?>"
				type="checkbox"
				value="yes"
			>
			<?php echo esc_html_x( 'Mark as an online event', 'Event State of being Online only checkbox label', 'tribe-ext-events-control' ); ?>
		</label>
	</p>
</div>
