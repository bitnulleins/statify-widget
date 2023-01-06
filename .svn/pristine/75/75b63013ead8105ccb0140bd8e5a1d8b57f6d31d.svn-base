<?php
/*
Plugin Name: Statify Widget: Popular Posts
Description: Widget for popular pages, posts and other custom content types – based on privacy conform statistic plugin "Statify" from pluginkollektiv.
Text Domain: statify-widget
Author: Finn Dohrn
Author URI: http://www.bit01.de/
Plugin URI: http://www.bit01.de/blog/statify-widget/
Version: 1.2.5
*/

require( 'Statify_Posts.class.php' );

define('DEFAULT_AMOUNT', 5);
define('DEFAULT_POST_TYPE','post');
define('DEFAULT_INTERVAL', 0);

class StatifyWidget extends WP_Widget {

	/*
	* Register StatifyWidget to Wordpress
	*/
	function __construct() {
		$widget_ops = array('classname' => 'statify-widget', 'description' => __('Shows the most popular content. Based on Statify Plugin.','statify-widget'));
		parent::__construct(
			'StatifyWidget',
			__('Statify Widget', 'plugin_name'),
			$widget_ops
		);

		add_shortcode( "statify-count", "Statify_Posts::statify_count_shortcode");
		add_shortcode( "statify-count-sum", "Statify_Posts::statify_count_sum_shortcode");
	}

	/*
	* Generating a from for settings
	*/
	function form($instance) {
		wp_enqueue_script( 'statify-widget-js', plugins_url( '/js/statify_widget.js', __FILE__ ));

		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'amount' => DEFAULT_AMOUNT,
			'post_type' => DEFAULT_POST_TYPE,
			'interval' => DEFAULT_INTERVAL,
			'show_visits' => 0,
			'list_style_type' => "ol",
			'suffix' => __('%VIEWS% views','statify-widget'),
			'post_category' => 0) );

    	$title = $instance['title'];
		$amount = $instance['amount'];
		$post_type = $instance['post_type'];
		$interval = $instance['interval'];
		$show_visits = $instance['show_visits'];
		$suffix = $instance['suffix'];
		$post_category = $instance['post_category'];
?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Widget title:','statify-widget'); ?>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
          </label>
        </p>
        <p class="post_select">
        <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e( 'Post type:','statify-widget'); ?>
        <select class="widefat" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
		  <option value="postpage"><?php _e( 'posts + pages','statify-widget'); ?></option>
          <?php
                $post_types = get_post_types( array('public'=>true, 'show_ui'=>true), 'objects' );
                foreach ( $post_types as $type ) {
                    echo '<option value="'. esc_attr($type->name) . '" '. selected( $post_type, $type->name, false ) .'>' . esc_attr($type->labels->name) . '</option>';
                }
          ?>
        </select>
        </p>
		<p class="category_select" style="display:none;">
		<label for="<?php echo $this->get_field_id('post_category'); ?>"><?php _e( 'Post category:','statify-widget'); ?>
      <select class="widefat" id="<?php echo $this->get_field_id('post_category'); ?>" name="<?php echo $this->get_field_name('post_category'); ?>">
			<option value="0">Alle Kategorien</option>
		  <?php
				$post_categories = get_categories( array('hide_empty'=>0 ),'objects' );
                foreach ( $post_categories as $type ) {
                    echo '<option value="'. esc_attr($type->cat_ID) . '" '. selected( $post_category, $type->cat_ID, false ) .'>' . esc_attr($type->name) . '</option>';
                }
          ?>
        </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e( 'Last ','statify-widget'); ?>
				<input id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" type="text" size="3" value="<?php echo esc_attr($interval); ?>" />
			</label><?php _e( ' days. (If enough stats exists)','statify-widget'); ?>
			<br /><small><?php _e( '0 days = show all items','statify-widget'); ?></small>
		</p>
        <p>
          <label for="<?php echo $this->get_field_id('amount'); ?>"><?php _e( 'Amounts:','statify-widget'); ?>
            <input id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>" type="text" size="3" value="<?php echo esc_attr($amount); ?>" />
          </label>
          <label for="<?php echo $this->get_field_id('show_visits'); ?>">
            <input class="checkbox widget-description" style="margin-left:15px;" type="checkbox" id="<?php echo $this->get_field_id('show_visits'); ?>" name="<?php echo $this->get_field_name('show_visits'); ?>" value="1" <?php checked($show_visits,1); ?>>
            <?php _e( 'Show view counter?','statify-widget'); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('suffix'); ?>"><?php _e( 'Custom text:','statify-widget'); ?>
            <input id="<?php echo $this->get_field_id('suffix'); ?>" class="widefat" name="<?php echo $this->get_field_name('suffix'); ?>" type="text" value="<?php echo esc_attr($suffix); ?>" />
			</label>
            <small><?php _e( '%VIEWS% = amount of views','statify-widget'); ?></small>
        </p>
<?php
	}

	/*
	* Override old instance with new instance.
	*/
	function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? $new_instance['post_type'] : DEFAULT_POST_TYPE;
		if($new_instance['interval'] != $old_instance['interval']) {
			delete_transient('statify_targets_'.$old_instance['interval']);
		}
		$instance['interval'] = ( ! empty( $new_instance['interval'] ) ) ? $new_instance['interval'] : DEFAULT_INTERVAL;
		$instance['amount'] = ( ! empty( $new_instance['amount'] ) ) ? sanitize_text_field( $new_instance['amount'] ) : DEFAULT_AMOUNT;
		$instance['show_visits'] = ( ! empty( $new_instance['show_visits'] ) ) ? $new_instance['show_visits'] : 0;
		$instance['suffix'] = ( ! empty( $new_instance['suffix'] ) ) ? sanitize_text_field( $new_instance['suffix'] ) : DEFAULT_SUFFIX;
		$instance['post_category'] = ( ! empty( $new_instance['post_category'] ) ) ? sanitize_text_field( $new_instance['post_category'] ) : 0;
		return $instance;
	}

	/*
	* Print the widget
	*/
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;

		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$amount = empty($instance['amount']) ? DEFAULT_AMOUNT : $instance['amount'];
		$post_type = empty($instance['post_type']) ? DEFAULT_POST_TYPE : $instance['post_type'];
		$interval = empty($instance['interval']) ? DEFAULT_INTERVAL : $instance['interval'];
		$show_visits = empty($instance['show_visits']) ? 0 : 1;
		$suffix =  empty($instance['suffix']) ? DEFAULT_SUFFIX : $instance['suffix'];
		$post_category = empty($instance['post_category']) ? 0 : $instance['post_category'];

		if (!empty($title)) echo $before_title . $title . $after_title;

		$popular_content = Statify_Posts::get_posts($post_type, $post_category, $amount, $interval);
		if (empty( $popular_content )) {
			echo "<p><?php __( 'There are no posts yet.','statify-widget'); ?></p>";
		} else {
			echo '<ol class="statify-widget-list">'."\n";
			foreach($popular_content as $post) {
				$_suffix = ($show_visits) ? ' <span>' . str_replace(__("%VIEWS%","statify-widget"), intval($post['visits']), $suffix) . '</span>' : '';
				echo '<li class="statify-widget-element"><a class="statify-widget-link" title="' . esc_html($post['title']) . '" href="' . esc_url($post['url']) . '">' . esc_html($post['title']) . '</a>'. $_suffix .'</li>'."\n";
			}
			echo "</ol>"."\n";
		}

		echo $after_widget;
	}

	/*
	* Return the statify widget class for the hook
	* @since 1.1.8
	*/

	function statify_widget_class_callback( $className ) {
		$widgetClass = $className;
	}

}

/*
* Print error message in admin interface
*/
function showErrorMessages() {
	$html = '<div class="error"><p>';
	$html .= __( 'Please install <a target="_blank" href="http://wordpress.org/plugins/statify/">Statify</a> plugin first.','statify-widget');
	$html .= '</p></div>';
	echo $html;
}

/*
* Check if Statify is acitivated
*/
function requires_statify_plugin() {
    $plugin_bcd_plugin = 'statify/statify.php';
    $plugin = plugin_basename( __FILE__ );
    $plugin_data = get_plugin_data( __FILE__, false );

	if ( !is_plugin_active( $plugin_bcd_plugin) ) {
        deactivate_plugins ( $plugin );
		add_action('admin_notices', 'showErrorMessages');
    }
}

/**
 * Register Statify-Widget
 *
 * @since 1.1.7
 */
function register_statify_widget() {
	register_widget( 'StatifyWidget' );
}
add_action( 'widgets_init', 'register_statify_widget' );
add_action( 'admin_init', 'requires_statify_plugin' );

/*
 * Get statify count for post id in themes or shortcode
 * @since 1.1.6
*/

function statify_count($post_id) {
	echo Statify_Posts::statify_count($post_id);
}

/*
 * Echo statify count for post id in themes or shortcode
 * @since 1.1.9
 */
function get_statify_count($post_id) {
	return Statify_Posts::statify_count($post_id);
}

/*
 * Return sum of all visits for the site
 * @since 1.2
 */
function get_statify_count_sum() {
	return Statify_Posts::statify_count_sum();
}

/*
 * Echo sum of all visits for the site
 * @since 1.2
 */
function statify_count_sum() {
	echo Statify_Posts::statify_count_sum();
}

/**
 * Load plugin textdomain.
 *
 * @since 1.1.9
 */
function statify_widget_load_textdomain() {
  load_plugin_textdomain( 'statify-widget', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'init', 'statify_widget_load_textdomain' );
?>