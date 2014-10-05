<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://cheffism.com
 * @since             1.0.0
 * @package           Post_Series_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Post Series Manager
 * Plugin URI:        http://cheffism.com/post-series-manager/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress dashboard.
 * Version:           1.0.0
 * Author:            Jeffrey de Wit, Adam Soucie
 * Author URI:        http://cheffism.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       post-series-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Post_Series_Manager {

	function __construct() {
		add_action( 'init', array( &$this, 'post_series_taxonomy' ) );
		add_action( 'plugins_loaded', array( &$this, 'post_series_i18n' ) );
		add_action( 'init', array( &$this, 'post_series_shortcodes' ) );
		add_filter( 'the_content', array( &$this, 'post_series_init' ) );
	}

	public function post_series_taxonomy() {
		// create a new taxonomy
		register_taxonomy(
			'post-series',
			'post',
			array(
				'label' => __( 'Post Series' ),
				'rewrite' => array( 'slug' => 'post-series' ),
			)
		);
	}

	public function post_series_i18n() {
		load_plugin_textdomain(
			'post-series-manager',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

	public function post_series_shortcodes() {
		add_shortcode('post_series_manager', array( &$this, 'post_series_manager_function') );
	}

	public function post_series_manager_function() {
		global $post;

		$shortcode_html = NULL;
		$series = get_the_terms( $post->ID, 'post-series' );

		if ( $series ) {
			var_dump($series);
			$series_block = '<div class="post-series-manager-block"><p>This post is part of a series: %s</p></div>';
			$series_link = '<a href="">'; 

		}

		return $shortcode_html;
	}

	public function post_series_init( $content ) {
        if( is_singular() ) {
            $html = do_shortcode("[post_series_manager]");
            $content = $content . $html;
        }
        
        return $content;
	}
}

new Post_Series_Manager;