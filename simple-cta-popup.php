<?php

/**
 * @link              https://arsamnet.com
 * @since             1.0.0
 * @package           Simple_CTA_Popup
 *
 * @wordpress-plugin
 * Plugin Name:       Simple CTA Popup
 * Plugin URI:        https://arsamnet.com/simple-cta-popup/
 * Description:       Wordpress simple call to action popup management.
 * Version:           1.1.0
 * Author:            Majid Barkhordari
 * Author URI:        https://arsamnet.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-cta-popup
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIMPLE_CTA_POPUP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-cta-popup-activator.php
 */
function activate_simple_cta_popup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-cta-popup-activator.php';
	Simple_CTA_Popup_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-cta-popup-deactivator.php
 */
function deactivate_simple_cta_popup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-cta-popup-deactivator.php';
	Simple_CTA_Popup_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_cta_popup' );
register_deactivation_hook( __FILE__, 'deactivate_simple_cta_popup' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-cta-popup.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_cta_popup() {

	$plugin = new Simple_CTA_Popup();
	$plugin->run();

}
run_simple_cta_popup();
