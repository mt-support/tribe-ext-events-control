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
			<h4><?php printf( esc_html__( 'Online %s:', 'the-events-calendar' ), tribe_get_event_label_singular() ); ?></h4>
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