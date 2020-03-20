<?php
namespace  Tribe\Extensions\EventsControl;

use WP_Post;
use Tribe__Template as Template;

/**
 * @var Template $this     Template instance we are using.
 * @var WP_Post  $post     Post we are dealing with.
 * @var Metabox  $metabox  The metabox instance.
 * @var array    $fields   Array of Field values.
 */
?>
<div class="tribe-events-control-metabox-container" style="margin-top: 24px;">
	<?php wp_nonce_field( $metabox::$nonce_action, "{$metabox::$id}[nonce]" ); ?>
	<p>
		<label for="<?php echo esc_attr( "{$metabox::$id}-status" ); ?>">
			<?php echo esc_html_x( 'Event Status:', 'Event status label the select field', 'tribe-ext-events-control' ); ?>
        </label>
        <select
            id="<?php echo esc_attr( "{$metabox::$id}-status" ); ?>"
            name="<?php echo esc_attr( "{$metabox::$id}[status]" ); ?>"
        >
            <option value=""></option>
            <option
                value="canceled"
                <?php selected( 'canceled' === $fields['status'] ) ?>
            >
                <?php echo esc_html_x( 'Canceled', 'Event status of being canceled in the select field', 'tribe-ext-events-control' ); ?>
            </option>
            <option
                value="postponed"
	            <?php selected( 'postponed' === $fields['status'] ) ?>
            >
                <?php echo esc_html_x( 'Postponed', 'Event status of being postponed in the select field', 'tribe-ext-events-control' ); ?>
            </option>
        </select>
	</p>
	<div
		class="tribe-dependent"
        data-depends="#<?php echo esc_attr( "{$metabox::$id}-status" ); ?>"
        data-condition="postponed"
	>
		<p>
			<label for="<?php echo esc_attr( "{$metabox::$id}-status-postponed-reason" ); ?>">
				<?php echo esc_html_x( 'Postponed Reason', 'Label for postponed reason field', 'tribe-ext-events-control' ); ?>
			</label>
			<textarea
                class="components-textarea-control__input"
				id="<?php echo esc_attr( "{$metabox::$id}-status-postponed-reason" ); ?>"
				name="<?php echo esc_attr( "{$metabox::$id}[status-postponed-reason]" ); ?>"
			><?php echo esc_textarea( $fields['status-postponed-reason'] ) ?></textarea>
		</p>
	</div>
	<div
		class="tribe-dependent"
		data-depends="#<?php echo esc_attr( "{$metabox::$id}-status" ); ?>"
		data-condition="canceled"
	>
		<p>
			<label for="<?php echo esc_attr( "{$metabox::$id}-status-canceled-reason" ); ?>">
				<?php echo esc_html_x( 'Canceled Reason', 'Label for canceled reason field', 'tribe-ext-events-control' ); ?>
			</label>
			<textarea
                class="components-textarea-control__input"
				id="<?php echo esc_attr( "{$metabox::$id}-status-canceled-reason" ); ?>"
				name="<?php echo esc_attr( "{$metabox::$id}[status-canceled-reason]" ); ?>"
			><?php echo esc_textarea( $fields['status-canceled-reason'] ) ?></textarea>
		</p>
	</div>
	<p>
		<label for="<?php echo esc_attr( "{$metabox::$id}-online" ); ?>">
			<input
				id="<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
				name="<?php echo esc_attr( "{$metabox::$id}[online]" ); ?>"
				type="checkbox"
				value="yes"
                <?php checked( $fields['online-url'] ); ?>
			>
			<?php echo esc_html_x( 'Mark as an online event', 'Event State of being Online only checkbox label', 'tribe-ext-events-control' ); ?>
		</label>
	</p>
	<div
		class="tribe-dependent"
		data-depends="#<?php echo esc_attr( "{$metabox::$id}-online" ); ?>"
		data-condition-checked
	>
        <p>
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
        </p>
	</div>
</div>
