<?php

/**
 * Main class return the posts
 * 
 * @since 1.0
 */
class Statify_Posts {
	
	/**
	* Return the content
	*
	* @since   1.0
	* @change  1.4.6
	*/
	public static function get_post_ids($post_type, $post_category, $amount, $days) {
		$posts = array();
		$counter = 0;
		$wpurl = parse_url(get_bloginfo('wpurl'));
		$targets = self::get_all_targets(intVal($days));
		$show_on_front = get_option('show_on_front');
		$page_for_posts = get_option( 'page_for_posts' );

		foreach ($targets as $entry) {
			$clear_url = str_replace($wpurl['host'],"",$entry['url']);
			$id = $entry['id'];

			// Add "frontpage" view counter if blog view is frontpage
			if ($clear_url == '/' && 'page' != $show_on_front) {
				if ($post_type != 'page' && $post_type != 'postpage') continue;
				if (!isset($posts[0])) $posts[0] = 0;
				$posts[0] += $entry['count'];
				continue;
			}
			
			// Overwrite id with selected frontpage, if option is activated
			if ($id == 0 && 'page' == $show_on_front) {
				$id = $page_for_posts;
			}
			
			// Get page by ID
			$page = get_post($id);
			
			// Find statistics for published "post&page" entries
			if ( (isset($page->post_type) && ($page->post_type == $post_type || $post_type == 'postpage')) && (isset($page->post_status) && $page->post_status == 'publish') ) {

				if (!empty($page->ID)) {
					// When category is select, then ignore other posts!
					if ($post_type == 'post' && $post_category > 0) {
						$categories = get_the_category($page->ID);
						foreach($categories as $category) $termIDArray[] = $category->term_id;
						if (!in_array($post_category,$termIDArray)) continue;
					}
					
					if (!isset($posts[$page->ID])) $posts[$page->ID] = 0;
					$posts[$page->ID] += $entry['count'];
				}
			}
			if (sizeof($posts) >= $amount) break;
		}
		
		return $posts;
	}
	
	/**
	* Return array of post objects
	*
	* @since   1.3
	*/
	public static function get_posts($post_type, $post_category, $amount, $days) {
		$posts = self::get_post_ids($post_type, $post_category, $amount, $days);
		$wp_posts = array();
		
		foreach ($posts as $post_id=>$views) {
			$wp_posts[$post_id] = new Statify_Post($post_id, $views);
		}
		
		return $wp_posts;
	}
	
	/**
	* Return array of post objects
	*
	* @since   1.3
	*/
	public static function get_post_list($post_type, $post_category, $amount, $days) {
		return new WP_Query(array('post__in' =>array_keys(self::get_post_ids($post_type, $post_category, $amount, $days))));
	}

	/**
	* Sorted by views
	*
	* @since   1.0
	*/

	private static function visitSort($a, $b) {
		if ($a==$b) return 0;
		return ($a['visits']>$b['visits'])?-1:1;
	}

	/**
	* Returns amount of view per id
	*
	* @since   1.1.4
	* @change  1.4.6
	*/

	public static function get_statify_count($post_id, $days) {
		if (empty($post_id)) {
			global $post;
			$post_id = $post->ID;
		}

		$targets = self::get_all_targets(intval($days));
		$count = 0;

		foreach ($targets as $entry) {
			if ($entry['id'] == $post_id) {
				$count = $entry['count'];
				break;
			}
		}

		return $count;
	}

	/**
	* Returns all views
	*
	* @since   1.2
	* @change  1.4.6
	*/

	public static function statify_count_sum($days) {
		$wpurl = parse_url(get_bloginfo('wpurl'));
		$targets = self::get_all_targets(intval($days));
		return array_sum(array_column($targets, 'count'));
	}

	/**
	* Return amount of views per id
	*
	* @since   1.1.4
	* @change  1.1.6
	*/
	public static function statify_count($post_id, $days) {
		$count = self::get_statify_count($post_id, $days);
		return $count >= 0 ? $count : 0;
	}

	/**
	* The shorctode for call amount of views per id.
	*
	* @since   1.1.4
	* @change  1.3.1
	*/

	public static function statify_count_shortcode( $atts ) {
		global $post;

		// Attr
		$a = shortcode_atts( array(
			'prefix' => '',
			'suffix' => __('views','statify-widget'),
			'days' => 0
		), $atts );

		return $a['prefix'] . " " . self::statify_count($post->ID, $a['days']) . " " . $a['suffix'];
	}

	/**
	* The shortcode for call all amount of views.
	*
	* @since   1.2
	* @change  1.3.1
	*/

	public static function statify_count_sum_shortcode( $atts ) {
		global $post;

		// Attr
		$a = shortcode_atts( array(
			'prefix' => '',
			'suffix' => __('views','statify-widget'),
			'days' => 0
		), $atts );

		return $a['prefix'] . " " . self::statify_count_sum($a['days']) . " " . $a['suffix'];
	}

	/**
	* Return all targets from statify and saved the values for 4 minutes.
	*
	* @since   1.1
	* @change  1.4.6
	*/

	public static function get_all_targets($interval = 0)
	{
		$expiry_seconds = apply_filters( 'statify_targets_cache_expiry', STATIFY_WIDGET_DEFAULT_EXPIRATION );
		if (!is_numeric($expiry_seconds) || $expiry_seconds <= 0) {
			$expiry_seconds = STATIFY_WIDGET_DEFAULT_EXPIRATION;
		}
		
		/* Look for cached values */
		if ($data = get_transient(STATIFY_WIDGET_DEFAULT_TRANSIENT_PREFIX.$interval)) {
			return $data;
		}

		global $wpdb;
		
		$query = "
			SELECT COUNT(`target`) AS `count`, `target` AS `url`
			FROM `$wpdb->statify`
		";

		if ($interval > 0) {
			$timezone = new DateTimeZone(Statify_Posts::wp_timezone());
			$datetime = new DateTime('now', $timezone);
			$date = $datetime->modify("-{$interval} days")->format('Y-m-d');
			$query .= "WHERE `created` > '$date'\n";
		}

		$query .= "
			GROUP BY `target`
			ORDER BY `count` DESC
		";

		$data = $wpdb->get_results($query, ARRAY_A);

		if ($interval > 0) {
			$map = array_column(self::get_all_targets(), 'id', 'url');
			foreach ($data as &$item) {
				$item['id'] = $map[$item['url']] ?? 0;
			}
			unset($item);
		} else {
			foreach ($data as &$item) {
				$item['id'] = ($item['url'] == '/') ? 0 : url_to_postid($item['url']);
			}
			unset($item);
		}
		
		set_transient(
			STATIFY_WIDGET_DEFAULT_TRANSIENT_PREFIX.$interval, $data, $expiry_seconds
		);

		return $data;
	}
	
	/**
	 * Copy of wp_timezone_string() for fallback < WP v5.3
	 * @since 1.4.6
	*/
	private static function wp_timezone() {
		if (function_exists('wp_timezone_string')) {
			return wp_timezone_string();
		}
		
		$timezone_string = get_option( 'timezone_string' );

		if ( $timezone_string ) {
			return $timezone_string;
		}

		$offset  = (float) get_option( 'gmt_offset' );
		$hours   = (int) $offset;
		$minutes = ( $offset - $hours );

		$sign      = ( $offset < 0 ) ? '-' : '+';
		$abs_hour  = abs( $hours );
		$abs_mins  = abs( $minutes * 60 );
		$tz_offset = sprintf( '%s%02d:%02d', $sign, $abs_hour, $abs_mins );

		return $tz_offset;
	}
}