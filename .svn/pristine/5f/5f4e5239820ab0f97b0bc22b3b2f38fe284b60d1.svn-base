<?php

class Statify_Posts {
	/**
	* Gibt die Inhalte zurück
	*
	* @since   1.0
	* @change  1.1
	*/

	public static function get_posts($post_type, $amount, $interval) {
		$posts = array();
		$correct_posttypes = array('post','media','page');
		$counter = 0;
		$wpurl = parse_url(get_bloginfo('wpurl'));
		$targets = self::get_all_targets(intVal($interval));

		foreach ($targets as $entry) {
			$clear_url = str_replace($wpurl['path'],"",$entry['url']);
			$id = url_to_postid(home_url( $clear_url ));

			if ( $id == 0 ) {
				$page = get_page_by_path( $clear_url );
				if (empty($page) && get_option('show_on_front') == 'page') $page = get_page(get_option('page_on_front'));
			} else $page = get_page($id);
			
			if ( ($page->post_type == $post_type || $post_type == 'postpage') ) {
				// Startseite
				if ($clear_url == '/' || $post_type == 'page') {
					$posts[0]['title'] = __('Frontpage','statify-widget');
					$posts[0]['url'] = get_home_url();
					if ($posts[0]['visits'] == NULL) $posts[0]['visits'] = 0;
					$posts[0]['visits'] += $entry['count'];
				}
				
				if (!empty($page->ID)) {
					$posts[$page->ID]['title'] = strip_tags($page->post_title);
					$posts[$page->ID]['url'] = get_permalink($page->ID);
					if ($posts[$page->ID]['visits'] == NULL) $posts[$page->ID]['visits'] = 0;
					$posts[$page->ID]['visits'] += $entry['count'];
				}
			}
			if (sizeof($posts) >= $amount) break;
		}

		
		usort($posts, array("Statify_Posts", "visitSort"));
		return $posts;
	}

	/**
	* Sortiert nach Aufurfen
	*
	* @since   1.0
	*/

	private static function visitSort($a, $b) {
		if ($a==$b) return 0;
		return ($a['visits']>$b['visits'])?-1:1;
	}

	/**
	* Gibt Anzahl Aufrufe eines Beitrags wieder
	*
	* @since   1.1.4
	*/

	public static function get_statify_count($post_id) {
		if (empty($post_id)) {
			global $post;
			$post_id = $post->ID;
		}

		$wpurl = parse_url(get_bloginfo('wpurl'));
		$targets = self::get_all_targets(0);
		$count = -1;

		foreach ($targets as $entry) {
			$clear_url = str_replace($wpurl['path'],"",$entry['url']);
			$id = url_to_postid(home_url( $clear_url ));

			if ($id == $post_id) {
				$count = $entry['count'];
				break;
			}
		}

		return $count;
	}
	
	/**
	* Gibt Gesamtanzahl an Aufrufen zurück
	*
	* @since   1.2
	*/
	
	public static function statify_count_sum() {
		if (empty($post_id)) {
			global $post;
			$post_id = $post->ID;
		}

		$wpurl = parse_url(get_bloginfo('wpurl'));
		$targets = self::get_all_targets(0);
		$count = -1;

		foreach ($targets as $entry) {
			$count += $entry['count'];
		}

		return $count;
	}

	/**
	* Gibt Anzahl Aufrufe eines Beitrags wieder
	*
	* @since   1.1.4
	* @change  1.1.6
	*/

	public static function statify_count($post_id) {
		$count = self::get_statify_count($post_id);
		if ($count >= 0) {
			return $count;
		} else {
			return 0;
		}
	}

	/**
	* Gibt Anzahl Aufrufe eines Beitrags mit Hilfe eines Shortcodes wieder
	*
	* @since   1.1.4
	*/

	public static function statify_count_shortcode( $atts ) {
		global $post;

		// Attr
		$a = shortcode_atts( array(
			'prefix' => '',
			'suffix' => __('views','statify-widget')
		), $atts );

		return $a['prefix'] . " " . self::statify_count($post->ID) . " " . $a['suffix'];
	}
	
	/**
	* Gibt Anzahl Aufrufe eines Beitrags mit Hilfe eines Shortcodes wieder
	*
	* @since   1.2
	*/

	public static function statify_count_sum_shortcode( $atts ) {
		global $post;

		// Attr
		$a = shortcode_atts( array(
			'prefix' => '',
			'suffix' => __('views','statify-widget')
		), $atts );

		return $a['prefix'] . " " . self::statify_count_sum() . " " . $a['suffix'];
	}

	/**
	* Gibt alle Ziele zurück und cachet diese.
	*
	* @since   1.1
	*/

	public static function get_all_targets($interval)
	{
		/* Auf Cache zugreifen */
		/*if ($data = get_transient('statify_targets_'.$interval)) {
			return $data;
		}*/

		if ($interval > 0) {
			$date = date("Y-m-d", strtotime('-' . $interval . ' days'));
		}

		global $wpdb;

		if ($interval > 0) {
			$data = $wpdb->get_results(
				"SELECT COUNT(`target`) as `count`, `target` as `url` FROM `$wpdb->statify` WHERE `created` >= '$date' GROUP BY `target` ORDER BY `count` DESC",
				ARRAY_A
			);
		} else {
			$data = $wpdb->get_results(
				"SELECT COUNT(`target`) as `count`, `target` as `url` FROM `$wpdb->statify` GROUP BY `target` ORDER BY `count` DESC",
				ARRAY_A
			);
		}

		/* Merken */
		set_transient(
			'statify_targets_'.$interval, $data, 60 * 4 // = 4 Minuten
		);

		return $data;
	}

}