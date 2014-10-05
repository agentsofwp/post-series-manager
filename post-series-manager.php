<?php

/**
 *
 * @link              http://cheffism.com
 * @since             1.0.0
 * @package           Post_Series_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Post Series Manager
 * Plugin URI:        http://cheffism.com/post-series-manager/
 * Description:       This plugin will help you manage and display post series more easily. You'll be able to create/assign series and display other posts in the series.
 * Version:           1.0.0
 * Author:            Jeffrey de Wit, Adam Soucie, Highforge
 * Author URI:        http://highforge.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       post-series-manager
 * Domain Path:       /languages
 *
 *
 * Copyright 2014  Jeffrey de Wit (email : jeff@highforge.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Post_Series_Manager {

	function __construct() {
		register_activation_hook( __FILE__, array( &$this, 'post_series_manager_activate' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'post_series_manager_deactivate' ) );
		add_action( 'init', array( &$this, 'post_series_taxonomy' ) );
		add_action( 'plugins_loaded', array( &$this, 'post_series_i18n' ) );
		add_action( 'init', array( &$this, 'post_series_shortcodes' ) );
		add_filter( 'the_content', array( &$this, 'post_series_init' ) );
	}

	// register taxonomy and force rewrite flush when plugin is activated
	function post_series_manager_activate() {
		$this->post_series_taxonomy();
		flush_rewrite_rules();
	}

	// force rewrite flush when plugin is deactivated
	function post_series_manager_deactivate() {
		flush_rewrite_rules();
	}


	public function post_series_taxonomy() {
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
		add_shortcode('post_series_block', array( &$this, 'post_series_block_function') );
		add_shortcode('post_series_nav', array( &$this, 'post_series_nav_function') );
	}

	// post_series_manager shortcode output
	public function post_series_block_function() {
		global $post;

		$shortcode_html = NULL;
		$all_series = get_the_terms( $post->ID, 'post-series' );

		if ( $all_series ) {
			foreach( $all_series as $series ) {
				$prev = get_previous_post_link('%link', '%title', true, None, 'post-series' );
				$series_text = __('This post is part of the series');
				$series_block = '<div class="post-series-manager-block"><p>%s %s</p>';
				$series_link = sprintf('<a href="%s">%s</a>', get_term_link($series), $series->name);

				if ( $prev && is_single() ) {
					$series_previous_text = __('Read the previous post in ths series:');
					$series_block .= '<p>%s<br /> %s</p></div>';
				}
				
				$shortcode_html .= sprintf($series_block, $series_text, $series_link, $series_previous_text, $prev);
			}
		}
		return $shortcode_html;
	}

	public function post_series_nav_function() {
		global $post;

		$shortcode_html = NULL;
		$all_series = get_the_terms( $post->ID, 'post-series' );

		if ( $all_series ) {
			$series_text = __('Continue reading this series:');
			$series_nav = '<div class="post-series-nav"><p>%s<br /> %s</p></div>';
			$next = get_next_post_link('%link', '%title', true, None, 'post-series' );

			if ( $next && is_single() ) {
				$shortcode_html = sprintf($series_nav, $series_text, $next);
			}
		}

		return $shortcode_html;

	}

	// Automatically add shortcodes to post content
	public function post_series_content( $content ) {
        if( is_single() ) {
            $series_box = do_shortcode("[post_series_block]");
            $series_nav = do_shortcode("[post_series_nav]");
            $content = $series_box . $content . $series_nav;
        }
        
        return $content;
	}
}

new Post_Series_Manager;