<?php
namespace Tribe\Extensions\EventsControl;

use Tribe__Events__Main as Events_Plugin;
use Tribe__Template as Template;
use Tribe__Editor;
use Tribe__Events__Editor__Compatibility;
use WP_Post;
use Tribe__Utils__Array as Arr;

/**
 * Class Metabox
 *
 * @since   1.0.0
 *
 * @package Tribe\Extensions\EventsControl
 */
class Metabox {

	/**
	 * ID for the metabox in WP.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $id = 'tribe-events-control';

	/**
	 * Action name used for the nonce on saving the metabox.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $nonce_action = 'tribe-event-control-nonce';
	
	/**
	 * Stores the template class used.
	 *
	 * @since 1.0.0
	 *
	 * @var Template
	 */
	protected $template;

	/**
	 * Fetches the Metabox title.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html_x( 'Events Advanced Control', 'Meta box title for the Advanced Control', 'tribe-ext-events-control' );
	}

	/**
	 * Normally ran when the class is setting up but configures the template instance that we will use to render the metabox contents.
	 *
	 * @since 1.0.0
	 *
	 * @return void Setter with no return.
	 */
	public function set_template() {
		$this->template = new Template();
		$this->template->set_template_origin( tribe( Main::class ) );
		$this->template->set_template_folder( 'src/admin-views' );

		// Configures this templating class extract variables.
		$this->template->set_template_context_extract( true );
	}

	/**
	 * Gets the instance of template class set for the metabox.
	 *
	 * @since 1.0.0
	 *
	 * @return Template Instance of the template we are using to render this metabox.
	 */
	public function get_template() {
		return $this->template;
	}

	/**
	 * Render the actual metabox contents.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post Which post we are using here.
	 *
	 * @return false|string
	 */
	public function render( $post ) {
		$fields = [
			'status' => get_post_meta( $post->ID, Event_Meta::$key_status, true ),
			'status-canceled-reason' => get_post_meta( $post->ID, Event_Meta::$key_status_canceled_reason, true ),
			'status-postponed-reason' => get_post_meta( $post->ID, Event_Meta::$key_status_postponed_reason, true ),
			'online' => tribe_is_truthy( get_post_meta( $post->ID, Event_Meta::$key_online, true ) ),
			'online-url' => get_post_meta( $post->ID, Event_Meta::$key_online_url, true ),
		];
		$args = [
			'metabox' => $this,
			'post' => $post,
			'fields' => $fields,
		];

		return $this->get_template()->template( 'metabox/container', $args, true );
	}

	/**
	 * Register the metabox in WP system.
	 *
	 * @since 1.0.0
	 *
	 * @return void Registering has no return.
	 */
	public function register() {
		add_meta_box(
			static::$id,
			$this->get_title(),
			[ $this, 'render' ],
			Events_Plugin::POSTTYPE,
			'side',
			'normal'
		);
	}

	/**
	 * Register all the fields in the Rest API for this metabox.
	 *
	 * @since 1.0.0
	 *
	 * @return void Registering fields has no return.
	 */
	public function register_fields() {
		register_post_meta(
			'post',
			Event_Meta::$key_status,
			[
				'show_in_rest' => true,
				'single' => true,
				'type' => 'string',
				'auth_callback' => static function() {
					return current_user_can( 'edit_posts' );
				},
			]
		);
		register_post_meta(
			'post',
			Event_Meta::$key_status_canceled_reason,
			[
				'show_in_rest' => true,
				'single' => true,
				'type' => 'string',
				'auth_callback' => static function() {
					return current_user_can( 'edit_posts' );
				},
			]
		);
		register_post_meta(
			'post',
			Event_Meta::$key_status_postponed_reason,
			[
				'show_in_rest' => true,
				'single' => true,
				'type' => 'string',
				'auth_callback' => static function() {
					return current_user_can( 'edit_posts' );
				},
			]
		);
		register_post_meta(
			'post',
			Event_Meta::$key_online,
			[
				'show_in_rest' => true,
				'single' => true,
				'type' => 'string',
				'auth_callback' => static function() {
					return current_user_can( 'edit_posts' );
				},
			]
		);
		register_post_meta(
			'post',
			Event_Meta::$key_online_url,
			[
				'show_in_rest' => true,
				'single' => true,
				'type' => 'string',
				'auth_callback' => static function() {
					return current_user_can( 'edit_posts' );
				},
			]
		);
	}

	/**
	 * Is current request bulk edit?
	 *
	 * @since 1.0.0
	 *
	 * @return bool If the current request is a bulk edit.
	 */
	protected function is_bulk_editing() {
		return isset( $_GET['bulk_edit'] );
	}

	/**
	 * Is current request a inline save.
	 *
	 * @since 1.0.0
	 *
	 * @return bool If the current request is a inline save.
	 */
	protected function is_inline_save() {
		return 'inline-save' === tribe_get_request_var( 'action' );
	}

	/**
	 * Saves the metabox, which will be triggered in `save_post`.
	 *
	 * @since 1.0.0
	 *
	 * @todo Requires implementation of any saving.
	 *
	 * @param int     $post_id Which post ID we are dealing with when saving.
	 * @param WP_Post $post    WP Post instance we are saving.
	 * @param boolean $update  If we are updating the post or not.
	 *
	 * @return void Just saving requires no return.
	 */
	public function save( $post_id, $post, $update ) {
		$context = tribe_context();

		// Skip non-events.
		if ( ! tribe_is_event( $post_id ) ) {
			return;
		}

		// All fields will be stored in the same array for simplicity.
		$data = tribe_get_request_var( static::$id, [] );

		// Add nonce for security and authentication.
		$nonce_name = Arr::get( $data, 'nonce', false );

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, static::$nonce_action ) ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_tribe_events', $post_id ) ) {
			return;
		}

		if  ( $this->is_bulk_editing() ) {
			return;
		}

		if  ( $this->is_inline_save() ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$status = Arr::get( $data, 'status', false );

		if ( $status ) {
			update_post_meta( $post_id, Event_Meta::$key_status, $status );

			$status_canceled_reason = Arr::get( $data, 'status-canceled-reason', false );
			if ( $status_canceled_reason ) {
				$status_canceled_reason = wp_kses_post( $status_canceled_reason );
				update_post_meta( $post_id, Event_Meta::$key_status_canceled_reason, $status_canceled_reason );
			} else {
				delete_post_meta( $post_id, Event_Meta::$key_status_canceled_reason );
			}

			$status_postponed_reason = Arr::get( $data, 'status-postponed-reason', false );
			if ( $status_postponed_reason ) {
				$status_postponed_reason = wp_kses_post( $status_postponed_reason );
				update_post_meta( $post_id, Event_Meta::$key_status_postponed_reason, $status_postponed_reason );
			} else {
				delete_post_meta( $post_id, Event_Meta::$key_status_postponed_reason );
			}
		} else {
			delete_post_meta( $post_id, Event_Meta::$key_status );
			delete_post_meta( $post_id, Event_Meta::$key_status_canceled_reason );
			delete_post_meta( $post_id, Event_Meta::$key_status_postponed_reason );
		}

		$online = Arr::get( $data, 'online', false );
		if ( $online ) {
			update_post_meta( $post_id, Event_Meta::$key_online, $online );
			update_post_meta( $post_id, Event_Meta::$key_online_url, Arr::get( $data, 'online-url', false ) );
		} else {
			delete_post_meta( $post_id, Event_Meta::$key_online );
			delete_post_meta( $post_id, Event_Meta::$key_online_url );
		}
	}

}