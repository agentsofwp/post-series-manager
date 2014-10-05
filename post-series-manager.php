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
 * Author:            Jeffrey de Wit
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

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-post-series-manager-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-post-series-manager-deactivator.php';

/** This action is documented in includes/class-post-series-manager-activator.php */
register_activation_hook( __FILE__, array( 'Post_Series_Manager_Activator', 'activate' ) );

/** This action is documented in includes/class-post-series-manager-deactivator.php */
register_deactivation_hook( __FILE__, array( 'Post_Series_Manager_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-post-series-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Post_Series_Manager() {

	$plugin = new Post_Series_Manager();
	$plugin->run();

}
run_Post_Series_Manager();
