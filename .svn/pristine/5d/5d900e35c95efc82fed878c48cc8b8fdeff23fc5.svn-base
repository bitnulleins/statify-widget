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

			// Falls noch leer und Artikel als Startseite
			if (empty($page) && ($post_type == 'page' || $post_type == 'postpage')) {
				$posts[0]['title'] = __('Frontpage','statify-widget');
				$posts[0]['url'] = home_url("/");
				if ($posts[0]['visits'] == NULL) $posts[0]['visits'] = 0;
				$posts[0]['visits'] += $entry['count'];
				$counter++;
			}

			if ($post_type == "postpage") {
				if ($page->post_type == 'post' || $page->post_type == 'page') {
					$posts[$page->ID]['title'] = $page->post_title;
					$posts[$page->ID]['url'] = home_url($clear_url);
					if ($posts[$page->ID]['visits'] == NULL) $posts[$page->ID]['visits'] = 0;
					$posts[$page->ID]['visits'] += $entry['count'];
					$counter++;
				}
			} else if($page->post_type == $post_type) {
				$posts[$page->ID]['title'] = $page->post_title;
				$posts[$page->ID]['url'] = home_url($clear_url);
				if ($posts[$page->ID]['visits'] == NULL) $posts[$page->ID]['visits'] = 0;
				$posts[$page->ID]['visits'] += $entry['count'];
				$counter++;
			}

			if ($counter >= $amount) break;

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
	* Gibt Anzahl Aufrufe eines Beitrags wieder
	*
	* @since   1.1.4
	* @change  1.1.6
	*/

	public static function statify_count($post_id) {
		$count = self::get_statify_count($post_id);
		if ($count >= 0) {
			return self::get_statify_count($post_id);
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
	* Gibt alle Ziele zurück und cachet diese.
	*
	* @since   1.1
	*/

	public static function get_all_targets($interval)
	{
		/* Auf Cache zugreifen */
		if ($data = get_transient('statify_targets_'.$interval)) {
			return $data;
		}

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