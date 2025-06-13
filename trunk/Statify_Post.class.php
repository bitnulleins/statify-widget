<?php

final class Statify_Post {

	/**
	 * Post ID.
	 *
	 * @since 1.3.1
	 * @var int
	 */
	public $ID = 0;

	/**
	 * ID of post author.
	 *
	 * A numeric string, for compatibility reasons.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_author = 1;

	/**
	 * The post's local publication time.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_date = '0000-00-00 00:00:00';

	/**
	 * The post's GMT publication time.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_date_gmt = '0000-00-00 00:00:00';

	/**
	 * The post's content.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_content = '';

	/**
	 * The post's title.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_title = '';

	/**
	 * The post's excerpt.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_excerpt = '';

	/**
	 * The post's status.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_status = 'publish';

	/**
	 * Whether comments are allowed.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $comment_status = 'closed';

	/**
	 * Whether pings are allowed.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $ping_status = 'open';

	/**
	 * The post's password in plain text.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_password = '';

	/**
	 * The post's slug.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_name = '';

	/**
	 * URLs queued to be pinged.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $to_ping = '';

	/**
	 * URLs that have been pinged.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $pinged = '';

	/**
	 * The post's local modified time.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_modified = '0000-00-00 00:00:00';

	/**
	 * The post's GMT modified time.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_modified_gmt = '0000-00-00 00:00:00';

	/**
	 * A utility DB field for post content.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_content_filtered = '';

	/**
	 * ID of a post's parent post.
	 *
	 * @since 1.3.1
	 * @var int
	 */
	public $post_parent = 0;

	/**
	 * Views of a post's parent post.
	 *
	 * @since 1.3.9
	 * @var int
	 */
	public $post_views = 0;
	
	/**
	 * Permalink of a post's parent post.
	 *
	 * @since 1.3.9
	 * @var string
	 */
	public $post_permalink = '';
	
	/**
	 * Suffix of a post's parent post.
	 *
	 * @since 1.3.9
	 * @var string
	 */
	public $post_suffix = '';
	
	/**
	 * The unique identifier for a post, not necessarily a URL, used as the feed GUID.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $guid = '';

	/**
	 * A field used for ordering posts.
	 *
	 * @since 1.3.1
	 * @var int
	 */
	public $menu_order = 0;

	/**
	 * The post's type, like post or page.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_type = 'page';

	/**
	 * An attachment's mime type.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $post_mime_type = '';

	/**
	 * Cached comment count.
	 *
	 * A numeric string, for compatibility reasons.
	 *
	 * @since 1.3.1
	 * @var string
	 */
	public $comment_count = 0;

	/**
	 * Constructor.
	 *
	 * @since 3.5.0
	 * @change 1.3.9
	 *
	 * @param WP_Post|object $post Post object.
	 */
	public function __construct( $post_id, $views ) {
		if ($post_id > 0) {
			$post = get_page($post_id);
			foreach ( get_object_vars( $post ) as $key => $value ) {
				if (property_exists($this, $key)) {
					$this->$key = $value;
				}
			}
			$this->post_permalink = get_permalink($post->ID);
		} else {
			// Manipulate Frontpage Post (ID==0) to fix values
			$this->post_title = __('Frontpage','statify-widget');
			$this->post_permalink = get_home_url();
		}
		
		
		// Default both attributes
		$this->post_views = $views;
	}

	/**
	 * Convert object to array.
	 *
	 * @since 3.5.0
	 *
	 * @return array Object as array.
	 */
	public function to_array() {
		$post = get_object_vars( $this );

		foreach ( array( 'ancestors', 'page_template', 'post_category', 'tags_input' ) as $key ) {
			if ( $this->__isset( $key ) ) {
				$post[ $key ] = $this->__get( $key );
			}
		}

		return $post;
	}
}