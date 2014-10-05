<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://cheffism.com
 * @since      1.0.0
 *
 * @package    Post_Series_Manager
 * @subpackage Post_Series_Manager/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Post_Series_Manager
 * @subpackage Post_Series_Manager/admin
 * @author     Jeff de Wit <jeff@highforge.com>
 */
class Post_Series_Manager_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

		$this->register_shortcodes();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/post-series-manager-public.css', array(), $this->version, 'all' );

	}

	public function display_series( $content ) {
        global $post;    

        if( is_singular() ) {
            $html = do_shortcode("[post_series_manager]");
            $content = $content . $html;
        }
        
        return $content;
	}

	public function register_shortcodes() {
		add_shortcode('post_series_manager', array( &$this, 'post_series_manager_function') );
	}

	function post_series_manager_function() {
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

}
