<?php
/**
 * Events post main metabox
 *
 * @version 4.2
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

?>
<table id="tribe-online-events" class="online-event-wrapper eventtable">
	<thead>
	<tr>
		<td colspan="2" class="tribe_sectionheader">
			<h4 class="tribe-events-visuallyhidden"><?php printf( esc_html__( 'Online %s:', 'tribe-ext-events-control' ), tribe_get_event_label_singular() ); ?></h4>
		</td>
	</tr>
	<tr>
		<td>
			<?php printf( esc_html__( 'Online %s:', 'tribe-ext-events-control' ), tribe_get_event_label_singular() ); ?>
		</td>
		<td>
			<a class="tribe-configure-online-button button" href="#">
				<?php printf( esc_html__( 'Configure online %s', 'tribe-ext-events-control' ), tribe_get_event_label_singular_lowercase() ); ?>
			</a>
		</td>
	</tr>

	<tr>
		<td>
			<label for="<?php echo esc_attr( "{$metabox::$id}-online" ); ?>">
				<input
						id="<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
						name="<?php echo esc_attr( "{$metabox::$id}[online]" ); ?>"
						type="checkbox"
						value="yes"
					<?php checked( $fields['online'] ); ?>
				>
				<?php echo esc_html_x( 'Mark as an online event', 'Event State of being Online only checkbox label', 'tribe-ext-events-control' ); ?>
			</label>
		</td>
	</tr>

	<tr>
		<td>
			<div
					class="tribe-dependent"
					data-depends="#<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
					data-condition-checked
			>
				<label for="<?php echo esc_attr( "{$metabox::$id}-online-url" ); ?>">
					<?php echo esc_html_x( 'Live Stream URL', 'Label for live stream URL field', 'tribe-ext-events-control' ); ?>
				</label>
				<input
						id="<?php echo esc_attr( "{$metabox::$id}-online-url" ); ?>"
						name="<?php echo esc_attr( "{$metabox::$id}[online-url]" ); ?>"
						value="<?php echo esc_url( $fields['online-url'] ) ?>"
						type="url"
						class="components-text-control__input"
				>
			</div>
		</td>
	</tr>

	<tr>
		<td>
			<div
					class="tribe-dependent"
					data-depends="#<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
					data-condition-checked
			>
				<label for="<?php echo esc_attr( "{$metabox::$id}-online-button-text" ); ?>">
					<?php echo esc_html_x( 'Button Text', 'Label for online event watch button, defaults to watch', 'tribe-ext-events-control' ); ?>
				</label>
				<?php
					if ( empty(  $fields['online-button-text'] ) ) {
						$fields['online-button-text'] = _x( 'Watch', '', 'tribe-ext-events-control' );
					}
				?>
				<input
						id="<?php echo esc_attr( "{$metabox::$id}-online-button-text" ); ?>"
						name="<?php echo esc_attr( "{$metabox::$id}[online-button-text]" ); ?>"
						value="<?php echo esc_html( $fields['online-button-text'] ) ?>"
						type="text"
						class="components-text-control__input"
				>
			</div>
		</td>
	</tr>

	<tr>
		<td>
			<div
					class="tribe-dependent"
					data-depends="#<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
					data-condition-checked
			>
				<label for="<?php echo esc_attr( "{$metabox::$id}-online-button-text" ); ?>">
					<?php echo esc_html_x( 'Display Options', 'Label for online event watch button, defaults to watch', 'tribe-ext-events-control' ); ?>
				</label>

			</div>
		</td>
	</tr>

	<tr>
		<td>
			<label for="<?php echo esc_attr( "{$metabox::$id}-show-at-start" ); ?>">
				<input
						id="<?php echo esc_attr( "{$metabox::$id}-show-at-start" ); ?>"
						name="<?php echo esc_attr( "{$metabox::$id}[show-at-start]" ); ?>"
						type="checkbox"
						value="yes"
					<?php checked( $fields['show-at-start'] ); ?>
				>
				<?php echo esc_html_x( 'Only show when an event starts', 'Show watch button or embed only at the start of the event.', 'tribe-ext-events-control' ); ?>
			</label>
		</td>
	</tr>

	<tr>
		<td>
			<label for="<?php echo esc_attr( "{$metabox::$id}-show-on-event" ); ?>">
				<input
						id="<?php echo esc_attr( "{$metabox::$id}-show-on-event" ); ?>"
						name="<?php echo esc_attr( "{$metabox::$id}[show-on-event]" ); ?>"
						type="checkbox"
						value="yes"
					<?php checked( $fields['show-on-event'] ); ?>
				>
				<?php echo esc_html_x( 'Show on event page', 'Show watch button or embed only at the start of the event.', 'tribe-ext-events-control' ); ?>
			</label>
		</td>
	</tr>

	<tr>
		<td>
			<label for="<?php echo esc_attr( "{$metabox::$id}-show-on-views" ); ?>">
				<input
						id="<?php echo esc_attr( "{$metabox::$id}-show-on-views" ); ?>"
						name="<?php echo esc_attr( "{$metabox::$id}[show-on-views]" ); ?>"
						type="checkbox"
						value="yes"
					<?php checked( $fields['show-on-views'] ); ?>
				>
				<?php echo esc_html_x( 'Show on calendar views', 'Show watch button or embed only at the start of the event.', 'tribe-ext-events-control' ); ?>
			</label>
		</td>
	</tr>
	<?php
	//do_action( 'tribe_linked_post_table_top', $event->ID, $linked_post_type );
	?>
	</thead>
	<?php
	//$meta_box = new Tribe__Events__Linked_Posts__Chooser_Meta_Box( $event, $linked_post_type );
	//$meta_box->render();
	?>
</table>