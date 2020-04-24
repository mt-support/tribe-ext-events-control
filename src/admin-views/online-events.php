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
			<hr>
		</td>
	</tr>
	<tr>
		<td>
			<?php printf( esc_html__( 'Online %s:', 'tribe-ext-events-control' ), tribe_get_event_label_singular() ); ?>
		</td>
		<td>
			<div>
				<a
						class="tribe-configure-online-button button"
						href="#"
						class="tribe-dependent"
						data-depends="#<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
						data-condition-not-checked
				>
					<?php printf( esc_html__( 'Configure online %s', 'tribe-ext-events-control' ), tribe_get_event_label_singular_lowercase() ); ?>
				</a>

				<a
						class="dashicons dashicons-trash tribe-remove-online-event"
						href="#"
						class="tribe-dependent"
						data-depends="#<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
						data-condition-checked
				>
					<span class="screen-reader-text">Remove Online Event Settings</span>
				</a>
			</div>
			<div>
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
			</div>
		</td>
	</tr>
	</thead>
	<tbody
			class="tribe-dependent"
			data-depends="#<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
			data-condition-checked
	>
		<tr>
			<td>
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
			</td>
		</tr>

		<tr>
			<td>
				<label for="<?php echo esc_attr( "{$metabox::$id}-online-button-text" ); ?>">
					<?php echo esc_html_x( 'Button Text', 'Label for online event watch button, defaults to watch', 'tribe-ext-events-control' ); ?>
				</label>
				<?php
				if ( empty( $fields['online-button-text'] ) ) {
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
			</td>
		</tr>

		<tr>
			<td>
				<label for="<?php echo esc_attr( "{$metabox::$id}-online-button-text" ); ?>">
					<?php echo esc_html_x( 'Display Options', 'Label for online event watch button, defaults to watch', 'tribe-ext-events-control' ); ?>
				</label>
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
	</tbody>
</table>
<style>
	.tribe-events-visuallyhidden {
		border: 0;
		clip: rect(0 0 0 0);
		height: 1px;
		margin: -1px;
		overflow: hidden;
		padding: 0;
		position: absolute;
		width: 1px;
	}
</style>
<script>
	(function ( $ ) {
		let $tribe_online_events = $( '#tribe-online-events' );

		$( $tribe_online_events ).on( 'click', '.tribe-configure-online-button', function ( e ) {
			e.preventDefault();
			let $online_checkbox = $( '#tribe-events-control-online' );

			$( $online_checkbox ).prop( 'checked', true ).trigger( 'verify.dependency' );

		} )

		$( $tribe_online_events ).on( 'click', '.tribe-remove-online-event', function ( e ) {
			e.preventDefault();
			let $online_checkbox = $( '#tribe-events-control-online' );

			$( $online_checkbox ).prop( 'checked', false ).trigger( 'verify.dependency' );
		} );
	})( jQuery );
</script>