<?php
/**
 * Opinify plugin.
 *
 * @since             1.0
 * @package           Opinify
 *
 * @wordpress-plugin
 * Plugin Name:       Opinify
 * Description:       Opinify is a cool WordPress tool that lets people share their thoughts and reviews right on your website. You can easily set up review forms for users to fill out, show star ratings, and manage all the reviews smoothly. It helps you get more people involved, build trust, and get useful feedback.
 * Version:           1.0
 * Author:            Vrajesh Thakkar
 * Author URI:        https://profiles.wordpress.org/vrajeshthakkar/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       opinify
 * Domain Path:       /languages
 */

/**
 * Die if anyone accessed this file directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Sorry, you do not have permission to access this page directly.' );
}

/**
 * Define plugin text domain constant.
 */
if ( ! defined( 'OPINIFY_TEXT_DOMAIN' ) ) {
    define( 'OPINIFY_TEXT_DOMAIN', 'opinify' );
}

/**
 * Define plugin version constant.
 */
if ( ! defined( 'OPINIFY_VERSION' ) ) {
    define( 'OPINIFY_VERSION', '1.0' );
}

/**
 * Define plugin path constant.
 */
if ( ! defined( 'OPINIFY_PATH' ) ) {
    define( 'OPINIFY_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * Define plugin url constant.
 */
if ( ! defined( 'OPINIFY_URL' ) ) {
    define( 'OPINIFY_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 */
function activate_opinify() {
	require_once OPINIFY_PATH . 'includes/class-opinify-activator.php';
	Opinify_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_opinify' );

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_opinify() {
	require_once OPINIFY_PATH . 'includes/class-opinify-deactivator.php';
	Opinify_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_opinify' );

/**
 * The core plugin class file.
 */
require_once OPINIFY_PATH . 'includes/class-opinify.php';

/**
 * Plugin init.
 */
function opinify_init() {

	// Begins execution of the plugin.
	new Opinify();

}
add_action( 'plugins_loaded', 'opinify_init' );
